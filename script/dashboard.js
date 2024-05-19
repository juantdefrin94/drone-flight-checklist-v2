$(document).ready(function () {

    function init(){
        handleUI();
    }

    function handleUI(){
        let $sideBar = $('#sidebar-menu');
        let winHeight = window.screen.height;
        $sideBar.height(winHeight);
    }

    init();

});