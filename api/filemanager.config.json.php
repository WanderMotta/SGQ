<?php

namespace PHPMaker2024\sgq;

use Dflydev\DotAccessData\Data;
$RELATIVE_PATH = "../";

// Autoload
require_once "../vendor/autoload.php";

// Require files
require_once "../src/constants.php";
require_once "../src/config.php";
require_once "../src/phpfn.php";
$ConfigData = new Data($CONFIG); // Ensure that $ConfigData is accessible by Global Codes
require_once "../src/userfn.php";

// Config
$json = <<<'EOD'
{
    "_comment": "IMPORTANT : go to the wiki page to know about options configuration https://github.com/servocoder/RichFilemanager/wiki/Configuration-options",
    "options": {
        "theme": "flat-dark",
        "showTitleAttr": false,
        "showConfirmation": true,
        "browseOnly": false,
        "fileSorting": "NAME_ASC",
        "folderPosition": "bottom",
        "quickSelect": false,
        "logger": false,
        "allowFolderDownload": true,
        "allowChangeExtensions": false,
        "capabilities": [
            "select",
            "upload",
            "download",
            "rename",
            "copy",
            "move",
            "delete",
            "extract",
            "createFolder"
        ]
    },
    "language": {
        "default": "en",
        "available": [
            "ar",
            "bs",
            "ca",
            "cs",
            "da",
            "de",
            "el",
            "en",
            "es",
            "fa",
            "fi",
            "fr",
            "he",
            "hu",
            "it",
            "ja",
            "nl",
            "pl",
            "pt",
            "ru",
            "sv",
            "th",
            "tr",
            "vi",
            "zh-CN",
            "zh-TW"
        ]
    },
    "formatter": {
        "datetime": {
            "skeleton": "yMMMdHm"
        }
    },
    "filetree": {
        "enabled": true,
        "foldersOnly": false,
        "reloadOnClick": true,
        "expandSpeed": 200,
        "showLine": true,
        "width": 200,
        "minWidth": 200
    },
    "manager": {
        "defaultViewMode": "grid",
        "dblClickOpen": false,
        "selection": {
            "enabled": true,
            "useCtrlKey": true
        },
        "renderer": {
            "position": false,
            "indexFile": "readme.md"
        }
    },
    "api": {
        "lang": "php",
        "connectorUrl": false,
        "requestParams": {
            "GET": {},
            "POST": {},
            "MIXED": {}
        }
    },
    "upload": {
        "multiple": true,
        "maxNumberOfFiles": 5,
        "chunkSize": false
    },
    "clipboard": {
        "enabled": true,
        "encodeCopyUrl": true
    },
    "filter": {
        "image": [
            "jpg",
            "jpeg",
            "gif",
            "png",
            "svg"
        ],
        "media": [
            "ogv",
            "avi",
            "mkv",
            "mp4",
            "webm",
            "m4v",
            "ogg",
            "mp3",
            "wav"
        ],
        "office": [
            "txt",
            "pdf",
            "odp",
            "ods",
            "odt",
            "rtf",
            "doc",
            "docx",
            "xls",
            "xlsx",
            "ppt",
            "pptx",
            "csv",
            "md"
        ],
        "archive": [
            "zip",
            "tar",
            "rar"
        ],
        "audio": [
            "ogg",
            "mp3",
            "wav"
        ],
        "video": [
            "ogv",
            "avi",
            "mkv",
            "mp4",
            "webm",
            "m4v"
        ]
    },
    "search": {
        "enabled": true,
        "recursive": false,
        "caseSensitive": false,
        "typingDelay": 500
    },
    "viewer": {
        "absolutePath": true,
        "previewUrl": false,
        "image": {
            "enabled": true,
            "lazyLoad": true,
            "showThumbs": true,
            "thumbMaxWidth": 64,
            "extensions": [
                "jpg",
                "jpe",
                "jpeg",
                "gif",
                "png",
                "svg"
            ]
        },
        "video": {
            "enabled": true,
            "extensions": [
                "ogv",
                "mp4",
                "webm",
                "m4v"
            ],
            "playerWidth": 400,
            "playerHeight": 222
        },
        "audio": {
            "enabled": true,
            "extensions": [
                "ogg",
                "mp3",
                "wav"
            ]
        },
        "iframe": {
            "enabled": true,
            "extensions": [
                "htm",
                "html"
            ],
            "readerWidth": "95%",
            "readerHeight": "600"
        },
        "opendoc": {
            "enabled": true,
            "extensions": [
                "pdf",
                "odt",
                "odp",
                "ods"
            ],
            "readerWidth": "640",
            "readerHeight": "480"
        },
        "google": {
            "enabled": true,
            "extensions": [
                "doc",
                "docx",
                "xls",
                "xlsx",
                "ppt",
                "pptx"
            ],
            "readerWidth": "640",
            "readerHeight": "480"
        },
        "codeMirrorRenderer": {
            "enabled": true,
            "extensions": [
                "txt",
                "csv"
            ]
        },
        "markdownRenderer": {
            "enabled": true,
            "extensions": [
                "md"
            ]
        }
    },
    "editor": {
        "enabled": true,
        "theme": "default",
        "lineNumbers": true,
        "lineWrapping": true,
        "codeHighlight": true,
        "matchBrackets": true,
        "extensions": [
            "html",
            "txt",
            "csv",
            "md"
        ]
    },
    "customScrollbar": {
        "enabled": true,
        "theme": "inset-2-dark",
        "button": true
    },
    "extras": {
        "extra_js": [],
        "extra_js_async": true
    },
    "url": "https://github.com/servocoder/RichFilemanager",
    "version": "2.7.6"
}
EOD;
$config = json_decode($json);

// Remove comment
$config->_comment = "";

// Language
$lang = CurrentLanguageID();
if (!in_array($lang, $config->language->available)) {
    $lang = explode("-", $lang)[0];
}
if (!in_array($lang, $config->language->available)) {
    $lang = "en"; // Fallback to English
}
$config->language->default = $lang;

// Connector URL (for vendor/hkvstore/richfilemanager/index.html)
$config->api->connectorUrl = "../../../api/filemanager.php";

// Preview URL (for vendor/hkvstore/richfilemanager/index.html)
$config->viewer->absolutePath = true;
$config->viewer->previewUrl = PathCombine(DomainUrl(), "" . GetUrl(Config("UPLOAD_DEST_PATH")), false);

// Output JSON
WriteJson($config);
