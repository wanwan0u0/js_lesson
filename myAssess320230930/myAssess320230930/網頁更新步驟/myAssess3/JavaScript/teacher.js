function upload(formId, s, uploadStatusId, fileid, isUploadId) {
    var formData = new FormData($('#' + formId)[0]);
    var sid = $('#add_question_sid').text();

    // 添加额外的参数到FormData对象
    formData.append('fileid', fileid);
    formData.append('sid', sid);
    formData.append('s', s);

    debugger
    $.ajax({
        url: 'upload.php', // 上传文件的PHP脚本
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            debugger
            // 处理上传成功的响应
            $('#' + uploadStatusId).html(response);
            $('#' + isUploadId).val('1');
        },
        error: function (xhr, status, error) {
            // 处理上传失败的情况
            console.error('上传失败:', status, error);
        }
    });
}

function isSelectedFile(_this, spandId) {

    var selectedFile = $(_this).val();
    if (selectedFile) {
        var fileName = $(_this)[0].files[0].name;
        $('#' + spandId).text(fileName);
    } else {
        alert('尚未选择文件');
        $('#' + spandId).text('尚未選擇任何檔案');
    }
}

function btn_queryPaper() {
    var sid = $('#id_of_paper').val();
    var formData = new FormData();
    formData.append('sid', sid);



    $.ajax({
        url: 'queryPaper.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response != '' || response != null) {

                var data = JSON.parse(response);

                $.each(data, function (index, row) {
                    var htmlstr = '<div>';
                    htmlstr += row.sid;
                    htmlstr += '<div>';

                    $('#exam_div').append(htmlstr);
                });
            }




        },
        error: function (xhr, status, error) {
            // 处理上传失败的情况
            console.error('上传失败:', status, error);
        }
    });

}

function get_question_byParas() {

    var formData = new FormData();
    var keyword = $('#floatingTextarea4').val();

    formData.append('keyword', keyword);

    $('#createExam_tablee2 >tbody').html('<tr>><td colspan="4">查詢中或無結果<td>');


    $.ajax({
        url: 'get_question_byParas.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {


            $('#createExam_tablee2 >tbody').html('');

            $.each(response, function (index, row) {

                var html = '<tr>'
                html += '<td>' + row.sid + '</td>';
                html += '<td>' + row.info + '</td>';
                html += '<td>' + row.keyword + '</td>';
                html += '<td><button onclick=addQuestion2Paper(' + "'" + row.sid + "'" + ')>加入</button></td>';
                html += '</tr>'
                $('#createExam_tablee2 >tbody').append(html);

            })

        },
        error: function (xhr, status, error) {
            console.error('錯誤:', status, error);
        }
    });

}

function addQuestion2Paper(questions_sid) {
    let exam_sid = $('#id_of_paper').val();

    var formData = new FormData();
    formData.append('questions_sid', questions_sid);
    formData.append('exam_sid', exam_sid);

    $.ajax({
        url: 'addQuestion2Paper.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {

            var data = JSON.parse(response);

            debugger
            if (data.status == '1') {
                alert('題目已加入');
            }
            else {
                alert('加入成功');

                $('#createExam_tablee1 > tbody').html('');

                $.each(data.data, function (index, row) {
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



        },
        error: function (xhr, status, error) {
            // 处理上传失败的情况
            console.error('加入失敗:', status, error);
        }
    });

}

function delQuestionFromPaper(id) {
    let exam_sid = $('#id_of_paper').val();

    var formData = new FormData();
    formData.append('id', id);
    formData.append('exam_sid', exam_sid);


    $.ajax({
        url: 'delQuestionFromPaper.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            debugger
            var data = JSON.parse(response);

            
            alert('刪除成功');

            $('#createExam_tablee1 > tbody').html('');

            $.each(data, function (index, row) {
                debugger
                var html = '<tr>'
                html += '<td>' + row.sid + '</td>';
                html += '<td>' + row.info + '</td>';
                html += '<td>' + row.keyword + '</td>';
                html += '<td><button onclick=delQuestionFromPaper(' + "'" + row.rowid + "'" + ')>刪除</button></td>';
                html += '</tr>'
                $('#createExam_tablee1 >tbody').append(html);

            })


        },
        error: function (xhr, status, error) {
            // 处理上传失败的情况
            console.error('加入失敗:', status, error);
        }
    });
}