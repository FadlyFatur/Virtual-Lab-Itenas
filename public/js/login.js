$('#btn-umum').click(function () {
    $(".dosen-input").css("display", "none");
    $(".maha-input").css("display", "none");
});

$('#btn-Dosen').click(function () {
    $(".dosen-input").css("display", "flex");
    $(".maha-input").css("display", "none");
});

$('#btn-Maha').click(function () {
    $(".maha-input").css("display", "flex");
    $(".dosen-input").css("display", "none");
});