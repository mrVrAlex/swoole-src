/* This is a generated file, edit the .stub.php file instead.
 * Stub hash: 0992d0656330dabae784e8e492a1db9938599430 */

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_exec, 0, 1, MAY_BE_ARRAY | MAY_BE_FALSE)
ZEND_ARG_TYPE_INFO(0, command, IS_STRING, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, get_error_stream, _IS_BOOL, 0, "false")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_Swoole_Coroutine_System_sleep, 0, 1, _IS_BOOL, 0)
ZEND_ARG_TYPE_INFO(0, seconds, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_Swoole_Coroutine_System_usleep, 0, 1, _IS_BOOL, 0)
ZEND_ARG_TYPE_INFO(0, microseconds, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_statvfs, 0, 1, MAY_BE_BOOL | MAY_BE_ARRAY)
ZEND_ARG_TYPE_INFO(0, path, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_readFile,
                                        0,
                                        1,
                                        MAY_BE_FALSE | MAY_BE_STRING)
ZEND_ARG_TYPE_INFO(0, filename, IS_STRING, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, flags, IS_LONG, 0, "0")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_writeFile,
                                        0,
                                        2,
                                        MAY_BE_BOOL | MAY_BE_LONG)
ZEND_ARG_TYPE_INFO(0, filename, IS_STRING, 0)
ZEND_ARG_TYPE_INFO(0, data, IS_STRING, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, flags, IS_LONG, 0, "0")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_wait, 0, 0, MAY_BE_BOOL | MAY_BE_ARRAY)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, timeout, IS_DOUBLE, 0, "-1")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_waitPid, 0, 1, MAY_BE_BOOL | MAY_BE_ARRAY)
ZEND_ARG_TYPE_INFO(0, pid, IS_LONG, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, timeout, IS_DOUBLE, 0, "-1")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_Swoole_Coroutine_System_waitSignal, 0, 1, _IS_BOOL, 0)
ZEND_ARG_TYPE_INFO(0, signalNum, IS_LONG, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, timeout, IS_DOUBLE, 0, "-1")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_waitEvent,
                                        0,
                                        2,
                                        MAY_BE_BOOL | MAY_BE_LONG)
ZEND_ARG_TYPE_INFO(0, fd, IS_MIXED, 0)
ZEND_ARG_TYPE_INFO(0, events, IS_LONG, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, timeout, IS_DOUBLE, 0, "-1")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_gethostbyname,
                                        0,
                                        1,
                                        MAY_BE_STRING | MAY_BE_FALSE)
ZEND_ARG_TYPE_INFO(0, domain, IS_STRING, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, family, IS_LONG, 0, "AF_INET")
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, timeout, IS_DOUBLE, 0, "-1")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_dnsLookup,
                                        0,
                                        1,
                                        MAY_BE_STRING | MAY_BE_FALSE)
ZEND_ARG_TYPE_INFO(0, domain, IS_STRING, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, timeout, IS_DOUBLE, 0, "5")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_MASK_EX(arginfo_class_Swoole_Coroutine_System_getaddrinfo,
                                        0,
                                        1,
                                        MAY_BE_ARRAY | MAY_BE_FALSE)
ZEND_ARG_TYPE_INFO(0, domain, IS_STRING, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, family, IS_LONG, 0, "AF_INET")
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, sockType, IS_LONG, 0, "SOCK_STREAM")
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, protocol, IS_LONG, 0, "STREAM_IPPROTO_TCP")
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, service, IS_STRING, 0, "null")
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, timeout, IS_DOUBLE, 0, "-1")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_Swoole_Coroutine_System_clearDNSCache, 0, 0, IS_VOID, 0)
ZEND_END_ARG_INFO()
