/**
 * @typedef {Omit<RequestInit, 'method'>} RequestConfig
 */
class Requester {
  /**
   * @private
   */
  static BASE_URL = 'http://localhost/php-intro'

  /**
   * @private
   * @param {string} url
   * @param {RequestInit} config
   */
  static async sendRequest(url, config = {}) {
    url = Requester.resolveUrl(url)
    const response = await fetch(`${this.BASE_URL}/${url}`, config)
    if (!response.ok) {
      const body = await response.json();
      throw new HttpError(response.status, body);
    }
    return response;
  }

  /**
   * @param {string} url
   * @param {RequestConfig} config
   */
  static get(url, config = {}) {
    return Requester.sendRequest(url, config)
  }

  /**
   * @param {string} url
   * @param {RequestConfig} config
   */
  static async put(url, config = {}) {
    return Requester.sendRequest(url, { ...config, method: "PUT" })
  }

  /**
   * @param {string} url
   * @param {RequestConfig} config
   */
  static post(url, config = {}) {
    return Requester.sendRequest(url, { ...config, method: "POST" })
  }

  /**
   * @param {string} url
   * @param {RequestConfig} config
   */
  static delete(url, config = {}) {
    return Requester.sendRequest(url, { ...config, method: "DELETE" })
  }

  /**
   * @private
   * @param {string} url
   */
  static resolveUrl(url) {
    return url.startsWith('/') ? url.substring(1) : url
  }
}

class HttpError extends Error {
  constructor(code, body) {
    super()
    this.body = body
    this.code = code
  }
}
