// passのバリデーション(js,php)
// mailのdb登録
// phpのバリデーション

let G_post_data = [];
let error = $('.error');


$(() => {


  // $(function () {
  //   $('.js-open').click(function () {
  //     console.log('click');
  //     $('#overlay, .modal-window').fadeIn();
  //   });
  //   $('.js-close').click(function () {
  //     $('#overlay, .modal-window').fadeOut();
  //     location.reload();
  //   });
  // });

  

  $(document).on('click', '.btn_sign', (e) => {

      e.preventDefault();

      error.text('');
  
      const name = $('.name').val();
      // console.log(name);

      const mail = $('.mail').val();
      // console.log(mail);

      const pass1 = $('.pass1').val();
      // console.log(pass1);
      
      const pass2 = $('.pass2').val();
      // console.log(pass2);


      
      let errors = [];

      if(name == '') {
          console.log('名前を入力して下さい');
          errors.push('名前を入力して下さい');
          // error.text('名前を入力して下さい');
          // return;
      } else if(name.length >= 10) {
          console.log('名前は10文字以内で入力して下さい');
          errors.push('名前は10文字以内で入力して下さい');
          // error.text('名前は10文字以内で入力して下さい');
          // return;
      }

      if(mail == '') {
          console.log('メールアドレスを入力して下さい');
          errors.push('メールアドレスを入力して下さい');
          // error.text('メールアドレスを入力して下さい');
          // return;
      } else if (!mail.match(/.+@.+\..+/)) {
          console.log('メールアドレスの形式が正しくありません');
          errors.push('メールアドレスの形式が正しくありません');
          // error.text('メールアドレスの形式が正しくありません');
          // return;
      }

      if(pass1 == '' || pass2 == '') {
          console.log('パスワードを入力して下さい');
          errors.push('パスワードを入力して下さい');
          // error.text('パスワードを入力して下さい');
          // return;
      } else if (pass1 !== pass2) {
          console.log('パスワードが一致していません');
          errors.push('パスワードが一致していません');
          // errors['pass_match'] = 'パスワードが一致していません';
          // error.text('パスワードが一致していません');
          // return;
      }

      if(errors.length > 0) {
        let text = '';
        for(let i = 0; i < errors.length; i++){
          text += errors[i] + '<br>';
          error.html(text);
        }
        return;
      }

      G_post_data = {name:name, mail:mail, pass:pass1, confi:pass2};
      // console.log(data);

      $('#overlay, .modal-window').fadeIn();
      $('.name_check').text('名前：'+name);
      $('.mail_check').text('メールアドレス：'+mail);
      


  });


  $('.js-close').click(function () {
    // console.log(data);
    $('#overlay, .modal-window').fadeOut();
    // location.reload();
    return;
  });

      

  $('.js-enter').click(function () {



    $.ajax({
      type: "POST",
      url: "signup.php",
      data: { "data" : G_post_data },
      dataType : "json"
    }).done(function(response){
      console.log(JSON.stringify(response));
      console.log('成功');

      if(response.status == 'success'){
        console.log(response.message)
        window.location.href = '/';
        // location.reload();
      } else {
        console.log(response.message)
        error.text(response.message)
      }

    }).fail(function(XMLHttpRequest, status, e){
      alert(e);
    });

    // location.reload();

  });


  





  $(function() {
      $('.toggle-pass').on('click', function() {
        $(this).toggleClass('fa-eye fa-eye-slash');
        var input = $(this).prev('input');
        if (input.attr('type') == 'text') {
          input.attr('type','password');
        } else {
          input.attr('type','text');
        }
      });
  });

});