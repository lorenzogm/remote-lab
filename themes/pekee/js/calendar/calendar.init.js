var categories = new Array();

Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};

function addCategory(id)
{
    var index = categories.indexOf(id);
    if(index == -1)
    {
        categories[categories.length] = id;
        $('#category-' + id).removeClass('removed-from-list');
        $('#category-' + id).addClass('added-to-list');
    }
    else
    {
        categories.remove(index);
        $('#category-' + id).removeClass('added-to-list');
        $('#category-' + id).addClass('removed-from-list');
    }
    $('#calendar').fullCalendar( 'refetchEvents' );
}

$(document).ready(function() {

        $('.show-category').addClass('removed-from-list');

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
                theme: true,
                header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'agendaWeek'
                },
                weekMode: 'liquid',
                aspectRatio: 2,
                editable: false,
                allDaySlot: false,
                eventSources: [
                    {
                        url: SITE_URL + 'lab/booking/data_feed/',
                        data:
                            {
                                categories : categories
                            }
                    }
                ],
                eventClick: function(calEvent, jsEvent, view){
                    window.location.href = SITE_URL + 'lab/booking/book_practice/' + calEvent.id;
                },
                loading: function( isLoading, view ){
                    if(isLoading)
                    {
                        $("#loader").show();
                    }
                    else
                    {
                        $("#loader").hide();
                    }
                }
        });

});
