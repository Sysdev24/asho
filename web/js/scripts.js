document.addEventListener('DOMContentLoaded', function() {
    var dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.stopPropagation();
            this.classList.toggle('active');
        });
    });
    document.addEventListener('click', function() {
        dropdownItems.forEach(function(item) {
            item.classList.remove('active');
        });
    });
});
