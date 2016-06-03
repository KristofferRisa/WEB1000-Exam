$(function () {
    
    // Finner aktivt meny object bassert på "breadcrumb" visningen
    var activeElemt = $('.breadcrumb > .active');
    console.log(activeElemt);
    if(activeElemt !== null && activeElemt !== undefined){
        var breadcrumb = $('.breadcrumb');
        
        if(breadcrumb.size() !== 2) {
            //Må finne treeview element og sette aktivt
            var treeviewText = $('.breadcrumb > li:nth-child(2)').text();
            var treeviews = $('.treeview > a > span');
            
            console.log(treeviews.length);
            
            var i;
            for (i = 0; i < treeviews.length; ++i) {
                if(treeviews[i].innerHTML === treeviewText) {
                    //legger til active css klasse på 
                    var treeviews1 = $('.treeview')[i];
                    //console.log(treeviews1)
                    treeviews1.className = 'treeview active';
                }
            } 
        }
        
        console.log(activeElemt);
        $('#'+activeElemt.text()).addClass('active');
        
    }
    
    $("#datepicker,#aktivFra,#aktivTil").datepicker({
        dateFormat: "dd-MM-yyyy",
        maxDate: '-1'
    });

    //$('#flyplassLandValg').dropdown();
    $('.ui.search.selection.dropdown').dropdown();
    
});