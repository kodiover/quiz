import Echo from 'laravel-echo';

window.pusher = require('pusher-js');

window.Echo = new Echo({
  broadcaster: "pusher",
  key: process.env.MIX_PUSHER_APP_KEY,
  wsHost: window.location.hostname,
  wsPort: 6001,
  disableStats: true,
});


// var channel = Echo.channel('Quiz.{quizSessionId}');
// channel.listen('.QuizSessionStarted', function(data) {
//   alert(JSON.stringify(data));
//   window.location.reload();
// });

// var channel = Echo.channel('Quiz.{quizSessionId}');
// channel.listen('.QuestionCompleted', function(data) {
//   alert(JSON.stringify(data));
//   window.location.reload();
// });

// var channel = Echo.channel('Quiz.{quizSessionId}');
// channel.listen('.NextQuestion', function(data) {
//   alert(JSON.stringify(data));
//   window.location.reload();
// });

// var channel = Echo.channel('User,Quiz.{quizSessionId}');
// channel.listen('.PlayerJoined', function(data) {
//   alert(JSON.stringify(data));
//   window.location.reload();
// });

// var channel = Echo.channel('User.Quiz.{quizSessionId}');
// channel.listen('.AnswerReceived', function(data) {
//   alert(JSON.stringify(data));
//   window.location.reload();
// });

