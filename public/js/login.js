$('#btn-masuk').click(function () {
    console.log('#btn-masuk');
    $("#login-form").css("display", "block");
    $("#regis-form").css("display", "none");
});

$('#btn-daftar').click(function () {
    console.log('#btn-daftar');
    $("#regis-form").css("display", "block");
    $("#login-form").css("display", "none");
});

$('#btn-umum').click(function () {
    console.log('#btn-masuk');
    $(".internal-input").css("display", "none");
});

$('#btn-itenas').click(function () {
    console.log('#btn-daftar');
    $(".internal-input").css("display", "flex");
});