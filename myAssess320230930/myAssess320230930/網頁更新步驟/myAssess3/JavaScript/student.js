function startExam() {
    let exam_sid = $('#txt_quizcode').val();

    if (exam_sid == '') {
        alert('考卷代碼不可為空白');
        return false;
    }

    $('.ExamPaper_AnserArea').html('');

    var formData = new FormData();
    formData.append('exam_sid', exam_sid);

    $.ajax({
        url: 'startExam.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            debugger
            var data = JSON.parse(response);


            if (data.status == '1') {
                $('#ExamPaper_id').val(data.examPaper_sid);

                var seq = 1;


                $.each(data.data, function (index, row) {
                    debugger


                    let questionText = row.info;
                    let questions_sid = row.questions_sid;
                    let option1 = row.optionStr1;
                    let option2 = row.optionStr2;
                    let option3 = row.optionStr3;
                    let add_infovideo = row.infoVideo;
                    let add_optionvideo1 = row.optionVideo1;
                    let add_optionvideo2 = row.optionVideo2;
                    let add_optionvideo3 = row.optionVideo3;

                    // 使用模板字符串来构建 HTML 片段，并插入变量
                    
                    let questionContent = `
                        <div class="question row" style="padding-top: 100px;">
                            <div class="info col-12 row">
                                <div class="col-2" style="text-align: right;"><input type="text" class="form-control Anser" name="Anser${seq}"
                                    qsid="${questions_sid}" style="width: 100px; float: right;" /></div>
                                <div class="col-2">問題 ${seq}</div>
                                <div class="col-4">${questionText}</div>
                                <div class="col-4">
                                ${add_infovideo == 1 ?
                            `<video controls width="300" height="180">
                                        <source src=".\\FileUpload\\${questions_sid}\\1.mp4" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>`: ''
                        }
                                
                                </div>
                            </div>
                            <div class="option col-12 row" style="padding-top: 50px;">
                                <div class="col-4"><span style="float: right;">(1)</span></div>
                                <div class="col-4">${option1}</div>
                                <div class="col-4">
                                ${add_optionvideo1 == 1 ?
                            `<video controls width="300" height="180">
                                        <source src=".\\FileUpload\\${questions_sid}\\2.mp4" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>`: ''
                        }
                                </div>
                            </div>
                            <div class="option col-12 row" style="padding-top: 10px;">
                                <div class="col-4"><span style="float: right;">(2)</span></div>
                                <div class="col-4">${option2}</div>
                                <div class="col-4">
                                ${add_optionvideo2 == 1 ?
                            `<video controls width="300" height="180">
                                        <source src=".\\FileUpload\\${questions_sid}\\2.mp4" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>`: ''
                        }                                
                                </div>
                            </div>
                            <div class="option col-12 row" style="padding-top: 10px;">
                                <div class="col-4"><span style="float: right;">(3)</span></div>
                                <div class="col-4">${option3}</div>
                                <div class="col-4">
                                ${add_optionvideo3 == 1 ?
                            `<video controls width="300" height="180">
                                        <source src=".\\FileUpload\\${questions_sid}\\2.mp4" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>`: ''
                        }                                                            
                                </div>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                    `;


                    debugger
                    $('#ExamPaper_AnserArea').append(questionContent);
                    seq++;
                })



                alert('試卷讀取成功');
                document.getElementById("stu_new_page2").style.display = "none";
                document.getElementById("stu_ExamPage").style.display = "block";
            }
            else {
                alert('查無此試卷');

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

            console.error('失敗:', status, error);
        }
    });






}

function fininshExam() {
    if (!confirm('是否交卷?')) {
        alert('不交卷');
        return false;
    }

    let Ansers = $('.Anser');
    let examPaper_id = $('#ExamPaper_id').val();



    var formData = new FormData();
    formData.append('examPaper_id', examPaper_id);

    var arr = [];

    $.each(Ansers, function (index, item) {
        let anser = $(item).val();
        let qsid = $(item).attr('qsid');
        arr.push({ anser: anser, qsid: qsid });
    })

    formData.append('Ansers', JSON.stringify(arr));


    $('#tb_ExamResult > tbody').html('');

    $.ajax({
        url: 'fininshExam.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {            
            var data = JSON.parse(response);    

            debugger
            


            $.each(data, function (index, row) {
                debugger
                var html = '<tr>'
                html += '<td>' + row.isCorrect + '</td>';
                html += '<td>' + row.Anser + '</td>';
                html += '<td>' + row.correctValue + '</td>';
                html += '<td>' + row.questions_sid + '</td>';
                html += '</tr>'
                $('#tb_ExamResult >tbody').append(html);


            })

            alert('交卷成功');

            document.getElementById("stu_ExamPage").style.display = "none";
            document.getElementById("stu_ExamResult").style.display = "block";


        },
        error: function (xhr, status, error) {
            // 处理上传失败的情况
            console.error('加入失敗:', status, error);
        }
    });


}

function goback_stuIndex(){

    document.getElementById("stu_ExamResult").style.display = "none";
    document.getElementById("btngrp2").style.display = "block";

}