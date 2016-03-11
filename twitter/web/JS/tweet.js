$(document).ready(function () {
    var tweets = $('.boxTweet');
    tweets.hide();
    var length = tweets.length;
    var nb = Math.floor((tweets.length) / 2);
    var j = 0;

    setInterval(function test()
    {
        tweets.eq(j).show();
        if(j !== 0 ){
            tweets.eq(j-1).hide();
        }
        if(j === length) {
            tweets.eq(j).hide();
            j = 0;
        }
        j++;
    }, 3000);
});