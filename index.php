<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ahmad Chatbot</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      background: #f1f3f5;
      padding: 30px;
      display: flex;
      justify-content: center;
    }

    .chat-container {
      background: #fff;
      max-width: 600px;
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      padding: 20px;
      display: flex;
      flex-direction: column;
    }

    .chat-box {
      flex: 1;
      height: 400px;
      overflow-y: auto;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      background: #fafafa;
    }

    .chat-message {
      margin-bottom: 10px;
      padding: 10px 14px;
      border-radius: 10px;
      max-width: 80%;
      line-height: 1.4;
    }

    .user-msg {
      background: #d1e7ff;
      align-self: flex-end;
      text-align: right;
    }

    .bot-msg {
      background: #e6e6e6;
      align-self: flex-start;
    }

    .input-area {
      display: flex;
      gap: 10px;
    }

    #prompt {
      flex: 1;
      padding: 10px 15px;
      font-size: 16px;
      border-radius: 8px;
      border: 1px solid #ccc;
      outline: none;
    }

    #send {
      padding: 10px 20px;
      background: #007bff;
      color: white;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    #send:hover {
      background: #0056b3;
    }
    h2{
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <div class="chat-container">
     <center><h2>Ahmad Chatbot</h2></center>
    <div class="chat-box" id="chatBox">
      <!-- Chat messages will appear here -->
    </div>

    <div class="input-area">
      <input type="text" id="prompt" placeholder="Ask something...">
      <button id="send">Send</button>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script>
    function appendMessage(message, type) {
      const msgClass = type === 'user' ? 'user-msg' : 'bot-msg';
      $('#chatBox').append(`<div class="chat-message ${msgClass}">${message}</div>`);
      $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
    }

    $('#send').on('click', function () {
      let prompt = $('#prompt').val().trim();
      if (prompt !== '') {
        appendMessage(prompt, 'user');
        $('#prompt').val('');

        $.ajax({
          type: 'POST',
          url: 'api.php',
          data: { prompt: prompt },
          success: function (data) {
            try {
              const parsed = JSON.parse(data);
              const reply = parsed.candidates[0].content.parts[0].text;
              appendMessage(reply, 'bot');
            } catch (e) {
              appendMessage('Error in response.', 'bot');
            }
          },
          error: function () {
            appendMessage('API call failed.', 'bot');
          }
        });
      }
    });

    $('#prompt').on('keypress', function (e) {
      if (e.which === 13) $('#send').click(); // Enter key sends message
    });
  </script>

</body>
</html>
