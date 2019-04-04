function deactivate(id) {
    $.post("../server/update_stat.php", {
        type: 'deactivate',
        uid: id
    }, function (data, status) {
    });
}
function activate(id) {
    $.post("../server/update_stat.php", {
        type: 'activate',
        uid: id
    }, function (data, status) {
    });
}