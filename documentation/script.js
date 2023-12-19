document.addEventListener("DOMContentLoaded", function () {
  var body = document.body;
  var video = document.getElementById("bgVideo");
  var playButton = document.getElementById("playButton")
  var GoButton = document.getElementById("GoButton")
  body.style.background = "black";

  playButton.addEventListener('click', function () {
    playButton.style.display = "none";
    GoButton.style.display = "none";
    video.play();
  })

  video.addEventListener("ended", function () {
    window.location.href = "https://www.canva.com/design/DAF3aDiAYg0/CDf3irfDZZQkMlmbLe3ZLA/view?utm_content=DAF3aDiAYg0&utm_campaign=designshare&utm_medium=link&utm_source=editor"
  });
});