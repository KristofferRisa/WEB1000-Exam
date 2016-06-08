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
    
    //Flere formater: http://eternicode.github.io/bootstrap-datepicker/
    $("#datepicker,#aktivFra,#aktivTil").datepicker({
        format: "yyyy/mm/dd",
        startView: 1,
        endDate: "-15y"
    });

      var currentDate = new Date();
  $('#dato').datepicker({
      inline: true,
      showOtherMonths: true,
      startDate:currentDate,
      calendarWeeks: true,
      todayBtn: "linked",
      todayHighlight: true,
      dayNamesMin: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat','Sun'],
      autoclose: true,
      format: 'yyyy/mm/dd'
  });



    //$('#flyplassLandValg').dropdown();
    $('.ui.search.selection.dropdown').dropdown();
    
});

