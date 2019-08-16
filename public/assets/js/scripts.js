//PARA DESPLEGAR EL MENU ACTIVO
$(document).ready(function () {
    $('ul.nav-sidebar').find('a.active').parents('li.has-treeview').children('.nav-link').addClass('active');
    $('ul.nav-sidebar').find('a.active').parents('li.has-treeview').addClass('menu-open');

    //Cerrar Las Alertas Automaticamente
    $('.alert[data-auto-dismiss]').each(function (index, element) {
        const $element = $(element),
            timeout = $element.data('auto-dismiss') || 5000;
        setTimeout(function () {
            $element.alert('close');
        }, timeout);
    });
});
