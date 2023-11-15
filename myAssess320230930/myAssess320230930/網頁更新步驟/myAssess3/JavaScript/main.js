//function loginpage() {
//    document.getElementById("btn_group1").style.display = "none";
//    //document.getElementById("stu_in").style.display = "none";
//    document.getElementById("login_form").style.display = "block";
//}

//function tea_lookexam() {
//  document.getElementById("tea_btngroup1").style.display = "none";
//  document.getElementById("tea_btngroup2").style.display = "block";
//}
function goback_btngrp1() {
  document.getElementById("tea_neww").style.display = "none";
  document.getElementById("tea_btngroup1").style.display = "block";

  $("#upload_text_area input").each(function () {
    // 将每个 input 的值设置为空字符串    
    $(this).val("");
  });
  $("#upload_text_area textarea").each(function () {
    // 将每个 input 的值设置为空字符串    
    $(this).val("");
  });

  $('#add_question_sid').text('');

  $('#add_videoFile_span1').text('未選擇任何檔案');
  $('#add_videoFile_span2').text('未選擇任何檔案');
  $('#add_videoFile_span3').text('未選擇任何檔案');
  $('#add_videoFile_span4').text('未選擇任何檔案');

  $('#add_uploadStatus1').html('');
  $('#add_uploadStatus2').html('');
  $('#add_uploadStatus3').html('');
  $('#add_uploadStatus4').html('');

  $('#keywordTextArea').val('');

}

function goback_btngrp1_2() {
  document.getElementById("tea_change_page").style.display = "none";
  document.getElementById("tea_btngroup1").style.display = "block";
}

function goback_btngrp1_3() {
  document.getElementById("tea_make_paper_page").style.display = "none";
  document.getElementById("tea_btngroup1").style.display = "block";
}

function tea_new() {
  document.getElementById("tea_btngroup1").style.display = "none";
  document.getElementById("tea_new_page").style.display = "block";
}

// function tea_new_confirm() {
//   document.getElementById("tea_new_page").style.display = "none";
//   document.getElementById("tea_neww").style.display = "block";
// }

function tea_new_confirm() {
  document.getElementById("tea_new_page").style.display = "none";
  document.getElementById("tea_neww").style.display = "block";

  $("#upload_text_area input").each(function () {
    // 将每个 input 的值设置为空字符串
    $(this).val("");
  });

  debugger
  $.ajax({
    url: 'create_question.php',
    method: 'GET', // 请求方法，可以是GET或POST    
    dataType: 'text', // 预期的响应数据类型，可以是json、html、text等
    success: function (response) {
      debugger
      $('#add_question_sid').text(response);
    },
    error: function (xhr, status, error) {
      console.error('AJAX请求失败：', status, error);
    }
  });


}


function new_question() {
  var qorans = document.getElementById("qorans");
  var value = qorans.options[qorans.selectedIndex].value;
  var text = qorans.options[qorans.selectedIndex].text;

  if (value == 1) {
    document.getElementById("upload_area_test").innerHTML = text;
    upload_form();
  } else if (value == 2) {
    document.getElementById("upload_area_test").innerHTML = text;
    upload_form();
  } else if (value == 3) {
    document.getElementById("upload_area_test").innerHTML = text;
    upload_form();
  } else if (value == 4) {
    document.getElementById("upload_area_test").innerHTML = text;
    upload_form();
  } else if (value == 5) {
    document.getElementById("upload_area_test").innerHTML = text;
    upload_form();
  }
}

function upload_form() {
  var form = document.getElementById("form");
  var value2 = form.options[form.selectedIndex].value;
  var text2 = form.options[form.selectedIndex].text;
  if (value2 == 1) {
    document.getElementById("upload_area_test").innerHTML += " " + text2;
    document.getElementById("upload_text_area").style.display = "block";
    document.getElementById("upload_video_area").style.display = "none";
  } else if (value2 == 2) {
    document.getElementById("upload_area_test").innerHTML += " " + text2;
    document.getElementById("upload_text_area").style.display = "none";
    document.getElementById("upload_video_area").style.display = "block";
  } else if (value2 == 3) {
    document.getElementById("upload_area_test").innerHTML += " " + text2;
    document.getElementById("upload_text_area").style.display = "block";
    document.getElementById("upload_video_area").style.display = "block";
  }
}

function upload_done() {
  var info = document.getElementById("info").value;
  var keywordTextArea = document.getElementById("keywordTextArea").value;
  var option1 = document.getElementById("option1").value;
  var option2 = document.getElementById("option2").value;
  var option3 = document.getElementById("option3").value;
  var isUpload1 = document.getElementById("add_isUpload1").value;
  var isUpload2 = document.getElementById("add_isUpload2").value;
  var isUpload3 = document.getElementById("add_isUpload3").value;
  var isUpload4 = document.getElementById("add_isUpload4").value;
  var sid = document.getElementById("add_question_sid").textContent;
  var selectedRadioVal = $("input[name='group1']:checked").attr('val');

  debugger
  var data = new FormData();
  data.append("info", info);
  data.append("keyWord", keywordTextArea);
  data.append("option1", option1);
  data.append("option2", option2);
  data.append("option3", option3);
  data.append("isUpload1", isUpload1);
  data.append("isUpload2", isUpload2);
  data.append("isUpload3", isUpload3);
  data.append("isUpload4", isUpload4);
  data.append("sid", sid);
  data.append("correctValue", selectedRadioVal);


  const requestURL = "./add_question.php";
  const request = new XMLHttpRequest();
  request.open("POST", requestURL);

  request.onreadystatechange = function () {
    if (request.readyState === 4 && request.status === 200) {
      // 请求成功，可以获取服务器回傳值
      const responseText = request.responseText;
      console.log('服务器回傳值:', responseText);
      alert(responseText);
      goback_btngrp1();

    } else if (request.readyState === 4) {
      // 请求完成，但不是200 OK状态
      console.error('请求失败，状态码:', request.status);
    }
  };

  request.send(data);
}

function tea_change() {
  document.getElementById("tea_btngroup1").style.display = "none";
  document.getElementById("tea_change_page").style.display = "block";

  const requestURL = "./get_question.php";
  const request = new XMLHttpRequest();
  request.open("GET", requestURL);
  request.responseType = "json";
  request.send();
  request.onload = () => {
    let data = request.response;
    let tbody = document.getElementById("change-question-table-body");
    for (let i = 0; i < data.length; i++) {
      // create <tr>
      let tr = document.createElement("tr");
      tbody.appendChild(tr);
      // create <th>
      let th = document.createElement("th");
      th.innerHTML = i + 1;
      tr.appendChild(th);
      // create <td>
      for (let key in data[i]) {
        let td = document.createElement("td");
        td.innerHTML = data[i][key];
        tr.appendChild(td);
      }
      // create <button>
      let btn = document.createElement("button");
      btn.innerHTML = "修改題目";
      btn.classList.add("btn", "btn-outline-secondary");
      let td = document.createElement("td");
      td.appendChild(btn);
      tr.appendChild(td);
    }
  };
}

function tea_makepaper() {
  document.getElementById("tea_btngroup1").style.display = "none";
  document.getElementById("tea_make_paper_intro").style.display = "block";
}

function makepaper_confirm() {
  document.getElementById("tea_make_paper_intro").style.display = "none";
  document.getElementById("tea_make_paper_page").style.display = "block";
}

function paper_newq() {
  let sid = $('#id_of_paper').val();
  if (sid == null || sid.trim() == '') {
    alert('考卷代碼不可為空白');

    return false;
  }

  $('#createExam_tablee1 >tbody').html('<tr>><td colspan="4">查詢中或無結果<td>');
  $('#createExam_tablee2 >tbody').html('<tr>><td colspan="4">查詢中或無結果<td>');

  var formData = new FormData();
  formData.append('sid', sid);

  $.ajax({
    url: 'create_paper.php',
    method: 'POST', // 请求方法，可以是GET或POST    
    dataType: 'json', // 预期的响应数据类型，可以是json、html、text等
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      debugger

      $('#createExam_tablee1 >tbody').html('');


      if (response.status == 'm') {
        alert("新增考卷成功");

      }

      if (response.status == 'd') {
        alert('讀取考卷成功')
        debugger
        if (response.data.length > 0) {         
          //已增加的題目顯示到畫面
          $.each(response.data, function (index, row) {
            debugger
            var html = '<tr>'
            html += '<td>' + row.sid + '</td>';
            html += '<td>' + row.info + '</td>';
            html += '<td>' + row.keyword + '</td>';
            html += '<td><button onclick=delQuestionFromPaper(' + "'" + row.rowid + "'" + ')>刪除</button></td>';
            html += '</tr>'
            $('#createExam_tablee1 >tbody').append(html);

          })
        }

      }


    },
    error: function (xhr, status, error) {
      console.error('AJAX请求失败：', status, error);
    }
  });


  document.getElementById("makepaper1").style.display = "none";
  document.getElementById("makepaper2").style.display = "block";
  document.getElementById("tea_make_paper_page").style.display = "none";



}

function goto_makepaper1() {
  document.getElementById("makepaper2").style.display = "none";
  document.getElementById("makepaper1").style.display = "block";
  document.getElementById("tea_make_paper_page").style.display = "block";
}

function paper_finish() {
  document.getElementById("tea_make_paper_page").style.display = "none";
  document.getElementById("tea_btngroup1").style.display = "block";
}


/*學生端*/
function keywordrsch() {
  document.getElementById("btngrp2").style.display = "none";
  document.getElementById("stu_new_page").style.display = "block";
}

function quizcodersch() {
  document.getElementById("btngrp2").style.display = "none";
  document.getElementById("stu_new_page2").style.display = "block";
}
