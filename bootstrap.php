<?php
require_once __DIR__ . "/connections/db.php";

require_once __DIR__ . "/exceptions/HttpException.php";

require_once __DIR__ . "/core/request.php";
require_once __DIR__ . "/core/response.php";
require_once __DIR__ . "/core/validator.php";

require_once __DIR__ . "/models/model.php";
require_once __DIR__ . "/models/book.php";
require_once __DIR__ . "/models/user.php";

require_once __DIR__ . "/services/user.service.php";

require_once __DIR__ . "/middlewares/middleware.php";
require_once __DIR__ . "/middlewares/logged.php";
require_once __DIR__ . "/middlewares/unlogged.php";

require_once __DIR__ . "/controllers/user.controller.php";
