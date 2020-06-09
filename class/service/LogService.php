<?php

namespace KarinP\TemplateWS\Service;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\LineFormatter;

class LogService {

    private $logger;

    public function __construct() {
        $config = ConfigService::getInstance()->loadConfig();

        $channel_name = $config["app"]["name"]??"unknown_channel";
        $this->logger = new Logger($channel_name);

        if ($config['log']) {
            if ($config['log']['type'] === "file") {
                $log_file = ($config['log']['dir']??"/tmp/").($config['log']['file']??"debug.log");
                $log_level = $config['log']['level']??Logger::DEBUG;
                $this->_setFileLogger($log_file, $log_level);
            } else {
                error_log("Error: Unknown Log Type: ".$config['log']['type']);
            }
        } else {
            // Use Default Setting
            $this->_setFileLogger('/tmp/debug.log', Logger::DEBUG);
        }

        // Set Timezone
        $loggerTimeZone = new \DateTimeZone('Asia/Hong_Kong');
        $this->logger->setTimezone($loggerTimeZone);
    }

    // PUBLIC  -----------------------------------------------------------

    public function debug(string $msg, array $extra_info = []): void {
        $this->logger->debug($msg, $this->_getContext($extra_info));
    }

    public function info(string $msg, array $extra_info = []): void {
        $this->logger->info($msg, $this->_getContext($extra_info));
    }

    public function notice(string $msg, array $extra_info = []): void {
        $this->logger->notice($msg, $this->_getContext($extra_info));
    }

    public function warn(string $msg, array $extra_info = []): void {
        $this->logger->warn($msg, $this->_getContext($extra_info));
    }

    public function error(string $msg, array $extra_info = []): void {
        $this->logger->error($msg, $this->_getContext($extra_info));
    }

    public function critical(string $msg, array $extra_info = []): void {
        $this->logger->critical($msg, $this->_getContext($extra_info));
    }

    public function alert(string $msg, array $extra_info = []): void {
        $this->logger->alert($msg, $this->_getContext($extra_info));
    }

    public function log(string $msg, int $log_level = Logger::DEBUG, array $extra_info = []): void {
        $this->logger->log($log_level, $msg, $this->_getContext($extra_info));
    }

    // PRIVATE -----------------------------------------------------------

    private function _getContext(array $info = []): array {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
			$exploded_text = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ipAddress = array_pop($exploded_text);
        }
        return array_merge($info, ["ip_addr" => $ipAddress]);
    }

    private function _getFormatter(
        string $dateFormat = "Y-m-d H:i:s",
        string $output = "[%datetime%] %level_name% %message% %context%\n"): LineFormatter {
        $formatter = new LineFormatter($output, $dateFormat);
        return $formatter;
    }

    private function _setFileLogger(string $log_file, int $log_level) {
        try {
            $stream = new StreamHandler($log_file, $log_level);
            $stream->setFormatter($this->_getFormatter());
            $this->logger->pushHandler($stream);
            $this->logger->pushHandler(new FirePHPHandler());
        } catch (\Exception $e) {
            error_log("Error: set logger failure ".$e->getMessage());
        }
    }

    private static $singleton;
    public static function getInstance(): self
    {
        return self::$singleton ?? self::$singleton = new self();
    }
}