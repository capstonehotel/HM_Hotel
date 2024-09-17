<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .chat-area {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            height: 400px; /* Adjust height as needed */
            display: flex;
            flex-direction: column;
        }
        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        .message {
            margin-bottom: 10px;
        }
        .message.sent .content {
            background-color: #495057;
            color: white;
            text-align: right;
        }
        .message.received .content {
            background-color: #007bff;
            color: white;
        }
        .message-form {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .message-form input {
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Chat List</h6>
                <!-- Additional buttons or actions can be added here -->
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Column 1: Chat List -->
                    <div class="col-md-4">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action active">John Doe</a>
                            <a href="#" class="list-group-item list-group-item-action">Jane Smith</a>
                            <a href="#" class="list-group-item list-group-item-action">David Johnson</a>
                            <a href="#" class="list-group-item list-group-item-action">Emily Davis</a>
                        </div>
                    </div>
                    <!-- Column 2: Chat Area -->
                    <div class="col-md-8">
                        <div class="chat-area">
                            <div class="chat-header" style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">
                                Chat with John Doe
                            </div>
                            <div class="chat-messages">
                                <div class="message received">
                                    <div class="content">Hello, how are you?</div>
                                </div>
                                <div class="message sent">
                                    <div class="content">I am good, thank you!</div>
                                </div>
                            </div>
                            <div class="message-form">
                                <input type="text" class="form-control" placeholder="Type a message...">
                                <button class="btn btn-primary ml-2"><i class="fa fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
