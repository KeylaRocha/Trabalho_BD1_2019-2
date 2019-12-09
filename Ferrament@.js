$('.ui.clearable.multiple.selection.dropdown').dropdown({
  on: 'click',
  allowAdditions: true,
  direction: 'downward',
  clearable: true,
  minSelections: 1,

})
;


$('.ui.radio.inverted.checkbox.1').on('click', function(){
    $('#extraPes').attr("style","display:inherit;");
	$('#extraJur').attr("style","display:none;");
  }
)
;

$('.ui.radio.inverted.checkbox.2').on('click', function(){
    $('#extraJur').attr("style","display:inherit;");
	$('#extraPes').attr("style","display:none;");
  }
)
;

$('#manut2').on('click', function(){
    $('#extraMan').attr("style","display:inherit;");
  }
)
;

$('#manut1').on('click', function(){
	$('#extraMan').attr("style","display:none;");
  }
)
;

$('.ui.dropdown').dropdown({
  on: 'click',
  allowAdditions: true,
  direction: 'downward',
  clearable: true
})
;

$("#modalButton").on('click',function(){
	$('.ui.basic.modal').modal('show');
});