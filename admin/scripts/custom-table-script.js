//Нижний скрол для талицы
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
    $("#table-user-result").removeClass("mCustomScrollbar");
    $("#table-subjects-information").removeClass("mCustomScrollbar");
}else{
    $("#table-user-result").mCustomScrollbar({
        axis:"x",
        mouseWheel: {
            // enable: true,
            scrollAmount: 400,
            // axis: "x",
            // preventDefault: true,
            // deltaFactor: 10000,
        },
    });

    $("#table-subjects-information").mCustomScrollbar({
        axis:"x",
        mouseWheel: {
            // enable: true,
            scrollAmount: 400,
            // axis: "x",
            // preventDefault: true,
            // deltaFactor: 10000,
        },
    });

    $("#table-questions-information").mCustomScrollbar({
        axis:"x",
        mouseWheel: {
            // enable: true,
            scrollAmount: 400,
            // axis: "x",
            // preventDefault: true,
            // deltaFactor: 10000,
        },
    });
}

//Добавление фильтрации
$(function() {
    $("#all-results-table").tablesorter({
        // hidden filter input/selects will resize the columns, so try to minimize the change
        // theme:'blue',
        widthFixed : true,
    
    
        headers: {
            // 0: { sorter: "select", filter: "parsed" },
            // 1: { sorter: "select", filter: "parsed" },
            // 2: { sorter: true, filter: false },
            // 3: { sorter: "input", filter: "parsed" },
            // 4: { sorter: "input", filter: "parsed" },
            // 5: { sorter: "input", filter: "parsed" },
            // 6: { sorter: "input", filter: "parsed" },
            // 7: { sorter: "input", filter: "parsed" },
            // 8: { sorter: "input", filter: "parsed" },
            // 9: { sorter: "input", filter: "parsed" },
            12: { sorter: false, filter: false }
        },
        widgets: [ "columns", "filter", "zebra" ],
    
        widgetOptions : {
            // extra css class applied to the table row containing the filters & the inputs within that row
            filter_cssFilter   : '',
    
            // If there are child rows in the table (rows with class name from "cssChildRow" option)
            // and this option is true and a match is found anywhere in the child row, then it will make that row
            // visible; default is false
            filter_childRows   : false,
    
            // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
            // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
            filter_hideFilters : false,
    
            // Set this option to false to make the searches case sensitive
            filter_ignoreCase  : true,
    
            // jQuery selector string of an element used to reset the filters
            // filter_reset : '.reset',
    
            // Use the $.tablesorter.storage utility to save the most recent filters
            // filter_saveFilters : true,
    
            // Delay in milliseconds before the filter widget starts searching; This option prevents searching for
            // every character while typing and should make searching large tables faster.
            // filter_searchDelay : 300,
    
            // Set this option to true to use the filter to find text from the start of the column
            // So typing in "a" will find "albert" but not "frank", both have a's; default is false
            // filter_startsWith  : false,
    
            filter_searchFiltered : false,
    
            // Add select box to 4th column (zero-based index)
            // each option has an associated function that returns a boolean
            // function variables:
            // e = exact text from cell
            // n = normalized value returned by the column parser
            // f = search filter input value
            // i = column index
            filter_functions : {
            // 	// Add select menu to this column
            // 	// set the column value to true, and/or add "filter-select" class name to header
            // 	// '.first-name' : true,
            // 	// Exact match only
                // 1 : function(e, n, f, i, $r, c, data) {
                // return e === f;
                // },
    
            }
        },
    });
});

//Добавление фильтарации
$(function() {
    $("#all-subjects-table").tablesorter({
        widthFixed : true,
        widgets: [ "columns", "filter", "zebra" ],
        headers: {
            7: { sorter: false, filter: false }
        },
        widgetOptions : {
            filter_cssFilter   : '',
            filter_childRows   : false,
            filter_hideFilters : false,
            filter_ignoreCase  : true,
            filter_searchFiltered : false,
            filter_functions : {

            }
        },
    });
});

//Добавление фильтарации
$(function() {
    $("#questions-table-by-subject").tablesorter({
        widthFixed : true,
        widgets: [ "columns", "filter", "zebra" ],
        headers: {
            0: { sorter: true, filter: false },
            1: { sorter: false, filter: false },
            9: { sorter: false, filter: false }
        },
        widgetOptions : {
            filter_cssFilter   : '',
            filter_childRows   : false,
            filter_hideFilters : false,
            filter_ignoreCase  : true,
            filter_searchFiltered : false,
            filter_functions : {

            }
        },
    });
});
