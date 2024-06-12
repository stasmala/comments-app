<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сomments</title>
    <link rel="stylesheet" href="https://bootstraptema.ru/plugins/2015/bootstrap3/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
        .comments .comment img {
            margin-right: 20px;
        }

        .comments .comment {
            padding: 6px;
        }

        .comments .comment:hover {
            /*background: #eee;*/
        }

        .comment {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .comment-header {
            font-weight: bold;
        }

        .comment-body {
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .comment-footer {
            margin-top: 10px;
        }

        .nested-comments {
            margin-left: 20px;
        }

        .input-group-text {
            font-size: 1.2rem;
            background-color: #f0f0f0;
            border-color: #ccc;
            color: #333;
        }

        .captcha-placeholder { margin-left: 10px;width: 40px;height: 40px;margin-right: 30px; }
    </style>
</head>
<body>
    <div class="container" style="margin-top:20px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Comments
                    </div>
                    <div class="panel-body comments" id="app">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>

