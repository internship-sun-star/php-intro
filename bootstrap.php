<?php
require_once __DIR__ . "/connections/db.php";

require_once __DIR__ . "/core/http-exception.php";
require_once __DIR__ . "/core/request.php";
require_once __DIR__ . "/core/response.php";
require_once __DIR__ . "/core/validator.php";

require_once __DIR__ . "/models/model.php";
require_once __DIR__ . "/models/book.php";
require_once __DIR__ . "/models/user.php";
require_once __DIR__ . "/models/user_token.php";

require_once __DIR__ . "/services/service.php";
require_once __DIR__ . "/services/user.service.php";
require_once __DIR__ . "/services/user_token.service.php";
require_once __DIR__ . "/services/book.service.php";

require_once __DIR__ . "/middlewares/middleware.php";
require_once __DIR__ . "/middlewares/authorized.php";
require_once __DIR__ . "/middlewares/unauthorized.php";

require_once __DIR__ . "/controllers/user.controller.php";
require_once __DIR__ . "/controllers/book.controller.php";
require_once __DIR__ . "/controllers/web.controller.php";
