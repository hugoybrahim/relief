
$(document).ready(function () {
    const sidebar = $('#sidebar');
    const toggleButton = $('#toggleSidebar');

    function toggleSidebar() {
        sidebar.toggleClass('active');
        toggleButton.toggleClass('active');
    }

    toggleButton.on('click', function () {
        toggleSidebar();
    });
});
