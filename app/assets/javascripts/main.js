$(function(){
  console.log('DOM ready');

  // Init Colorpicker
  $('#colorpicker').spectrum();

  // Update Artwork Preview
  $('#vinyl-artwork-url').change(function(){
    var value = $(this).val();
    console.log(value);
    $('#vinyl-artwork').attr('src', value);
  });
});