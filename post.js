$(() => {

    let error = $('.error');

    // const name = $('.user').val();
    // console.log(name);
    
    $(document).on('click', '.send', (e) => {

        e.preventDefault();
  
        error.text('');
    
        console.log('click');

        const id = $('.id').val();
        // console.log(id);

        const title = $('.name').val();
        // console.log(title);

        const body = $('.message').val();
        // console.log(body);

        const image = document.getElementById('image').files[0];

        // const image = $('image');
        // console.log(image);

        let errors = [];

        // if(title == '') {
        //     console.log('タイトルを入力して下さい');
        //     errors.push('タイトルを入力して下さい');
        // } else if(title.length >= 10) {
        //     console.log('タイトルは10文字以内で入力して下さい');
        //     errors.push('タイトルは10文字以内で入力して下さい');
        // }

        // if(body == '') {
        //     console.log('メッセージを入力して下さい');
        //     errors.push('メッセージを入力して下さい');
        // }

        // if(errors.length > 0) {
        //     let text = '';
        //     for(let i = 0; i < errors.length; i++){
        //       text += errors[i] + '<br>';
        //       error.html(text);
        //     }
        //     return;
        // }

        let fd = new FormData();
        fd.append('id', id);
        fd.append('title', title);
        fd.append('body', body);
        fd.append('image', image);

        // console.log(fd);

        // let data = {id:id, title:title, body:body};

        // console.log(data);
        
        $.ajax({
            type: "POST",
            url: "post_done.php",
            data: fd,
            processData: false,
            contentType: false,
            cache: false,
            // dataType : "json"
            // dataType : "text"
          }).done(function(response){
            console.log('成功');
            console.log(response);
      
            if(response.status == 'success'){
              console.log(response.message)
              location.reload();
            } else {
              const errors = response.errors;
              let message = "";  
              for( const key in errors){
                  console.log(errors[key]);
                  message += errors[key] + "<br>";
                  error.html(message);

                }
              // for(const error of errors){
              //   console.log(error);
              // }
              // console.log(Object.getPrototypeOf(errors).constructor.name);
              // console.log(Array.isArray(errors));
              // console.log(errors)
              // error.text(response.errors[key])
            }
      
          }).fail(function(XMLHttpRequest, status, e){
            alert(e);
          });




    });



    const G_POST_LIST = document.getElementById("post_list");
    // let G_RESPONSE = [];
    

    // function makePostCard(title, author, created, body, file = null) {
    //   const card = document.createElement("li");
    //   const title_node = document.createElement("div");
    //   const author_node = document.createElement("div");
    //   const created_node= document.createElement("div");
    //   const body_node = document.createElement("div");

    //   card.classList.add("lists");
    //   title_node.innerText = title;
    //   title_node.classList.add("list_title");
    //   author_node.innerText = author;
    //   author_node.classList.add("list_author");
    //   created_node.innerText = created;
    //   // created_node.classList.add("title_text");
    //   body_node.innerText = body;
    //   body_node.classList.add("list_body");


    //   if(file) {
    //     const file_node = document.createElement("img");
    //     file_node.setAttribute('src', '/images/'+file);
    //     file_node.classList.add("post_image");

    //     // file_node.setAttribute('src', file);
    //     card.append(title_node, author_node, created_node, body_node, file_node);
    //     G_POST_LIST.append(card);
    //   } else {
    //     card.append(title_node, author_node, created_node, body_node);
    //     G_POST_LIST.append(card);
    //   }
      
    // }

    // makeTaskCard("太郎", "たいとるうううう", "詳細文詳細文詳細文詳細文", "https://placehold.jp/300x200.png", "2022-8-4 12:34");
    // makeTaskCard("太郎2222", "22222", "2222222", null, "2022-8-4 12:34");

    // $(function(){

    //   // Ajax通信開始
    //   const res = $.ajax({
    //         url: 'get_done.php',
    //         type: 'get',
    //         cache: false,
    //         dataType: 'json',
    //         data: null,
    //     })
    //     .done(function(response) {
    //         // G_RESPONSE = response;
    //         // console.log(response);

    //         // console.log(response);
    //         for (let i = 0; i < response.length; i++) {
    //           makePostCard(
    //             response[i].title,
    //             response[i].author,
    //             response[i].posts_created_at,
    //             response[i].body,
    //             response[i].file_name
    //             // '/images/'+response[i].file_name
    //             // "/images/${posts[i].file_name}"
    //           );
    //         }
            

    //     })
    //     .fail(function(xhr, status, error) {
    //         console.log(xhr);
    //         console.log(status);
    //         console.log(error);
    //     })

    // });
    



    



    // const init = () => {

    //   // AjaxでDBからタスクを全取得
    //   $.ajax({
    //     type: "GET",
    //     url: "get_done.php",
    //     dataType:"json",
    //     // processData: false,
    //     // contentType: false,
    //     // cache: false,
    //   }).done(function(response){
        
    //     const posts = (response);
    //     console.log(posts);
        
    //     const post_list = $('#post_list')
    //     post_list.empty();
    
    //     for(let i=0; i<posts.length; i++) {
    //       // console.log(typeof(posts[i]));
          
    //       let Litag = "";

          
          
    //       if(!(posts[i].file_name == null)) {
          
          
    //         Litag = `<br><li class="posts"><h3>${posts[i].title}</h3><h4>${posts[i].author}</h4>${posts[i].posts_created_at}<br><h1>${posts[i].body}</h1><?php if (isset(${posts[i].file_name})) : ?><img class="task_image" src="/images/${posts[i].file_name}"><?php endif; ?></li><hr>`;
    //       }else { 
    //         // Litag = `<br><li class="posts"><h3>${posts[i].title}</h3><h4>${posts[i].author}</h4>${posts[i].posts_created_at}<br><h1>${posts[i].body}</h1><img src="/images/${posts[i].file_name}"></li><hr>`;
    //         Litag = `<br><li class="posts"><h3>${posts[i].title}</h3><h4>${posts[i].author}</h4>${posts[i].posts_created_at}<br><h1>${posts[i].body}</h1></li><hr>`;
    //       }
          
    //       // if(tasks[i].done === "1") {
    //       //   Litag = `<li class="task_line mb-1">${tasks[i].id} ： ${tasks[i].task} <button class="done_btn btn btn-success" data-id="${tasks[i].id}">完了</button> <button class="delete_btn btn btn-secondary" data-id="${tasks[i].id}">削除</button></li>`;
    //       // } else {
    //       //   Litag = `<li class="mb-1">${tasks[i].id} ： ${tasks[i].task} <button class="done_btn btn btn-success" data-id="${tasks[i].id}">完了</button> <button class="delete_btn btn btn-secondary" data-id="${tasks[i].id}">削除</button></li>`;
    //       // }
          

    //       post_list.append(Litag);
            

    //     }


    //   }).fail(function(XMLHttpRequest, status, e){
    //       alert(e);
    //   });
    
    // }

    // init();



    // $(document).on('click', '.delete_btn', (e) => {

    //   const id = e.target.getAttribute('data-id');

    //   console.log(e.target);
    //   console.log(id);

    //   $.ajax({
    //     type: "POST",
    //     url: "to_do_delete.php",
    //     data: { "id" : id },
    //   }).done(function(){
    //     console.log('成功')
    //     location.reload();
        
    //   }).fail(function(XMLHttpRequest, status, e){
    //     alert(e);
    //   });

    // });




    











});