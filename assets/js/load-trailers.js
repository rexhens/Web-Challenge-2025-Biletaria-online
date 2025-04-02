let player;
const videoIds = ["Bp-pEsoaIZA", "8zgOVbc1Yko", "Le9mmpl83Oc"];
let currentIndex = 0;

function loadYouTubeAPI() {
    const tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    const firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        height: '100%',
        width: '100%',
        videoId: videoIds[currentIndex],
        playerVars: {
            'autoplay': 1,
            'controls': 0,
            'rel': 0,
            'showinfo': 0
        },
        events: {
            'onStateChange': onPlayerStateChange
        }
    });
}

function onPlayerStateChange(event) {
    if (event.data === YT.PlayerState.ENDED) {
        nextVideo();
    }
}

function nextVideo() {
    currentIndex = (currentIndex + 1) % videoIds.length;
    player.loadVideoById(videoIds[currentIndex]);
}

function prevVideo() {
    currentIndex = (currentIndex - 1 + videoIds.length) % videoIds.length;
    player.loadVideoById(videoIds[currentIndex]);
}

document.getElementById('nextBtn').addEventListener('click', nextVideo);
document.getElementById('prevBtn').addEventListener('click', prevVideo);

document.addEventListener('keydown', function (event) {
    if (event.key === 'ArrowRight') {
        nextVideo();
    } else if (event.key === 'ArrowLeft') {
        prevVideo();
    }
});

loadYouTubeAPI()