//PARA DESPLEGAR EL MENU ACTIVO
$(document).ready(function () {
    $('ul.nav-sidebar').find('a.active').parents('li.has-treeview').children('.nav-link').addClass('active');
    $('ul.nav-sidebar').find('a.active').parents('li.has-treeview').addClass('menu-open');
});
