// 影片介面 - 創建、定義id，並加入 main 標籤(主工作區)中。
let videoBox = document.createElement("div");
videoBox.setAttribute("id", "videoBox");
document.querySelector('main').appendChild(videoBox);

// 影片介面 - 新增關閉按鈕、定義id、定義按鈕方法，並加入影片介面中。
let closeButton = document.createElement("button");
closeButton.innerHTML = "X"
closeButton.setAttribute("id", "closeButton");
closeButton.setAttribute("onclick", "closeVideo()")
videoBox.appendChild(closeButton);

// 影片播放器 - 創建並加入影片介面中
const video = document.createElement("video");
videoBox.appendChild(video);

// global，題目數量，呼叫loadExam後賦值
let questionNum;

// 讀取exam.json，呼叫 loadQuestion 並將json內部物件或陣列傳入
let loadExam = () => {

    // questionData 中的測驗說明json檔，每場測驗都需要一個說明檔
    const requestURL = './questionData/exam.json';
    const request = new XMLHttpRequest();
    request.open('GET', requestURL);
    request.responseType = 'json';
    request.send();
    request.onload = () => {
        const response = request.response;
        // 儲存題目數量
        questionNum = response.length;
        loadQuestion(response);
    }

}

let loadQuestion = (questionDatas) => {

    // 傳入資料包含每個題目的資料夾路徑、題目描述檔檔名，依照順序讀取
    for (let data of questionDatas) {

        // 製作題目路徑
        const requestURL = `./questionData/${data.questionFolder}/${data.json}`

        // 目前讀取資料夾
        const nowFolder = data.questionFolder;
        const request = new XMLHttpRequest();
        request.open('GET', requestURL);
        request.responseType = 'json';
        request.send();
        request.onload = () => {
            const response = request.response;
            // 呼叫 renderAll 方法，依照題目描述檔渲染畫面。
            renderAll(response, nowFolder);
        }
    }

}


let renderAll = (question, nowFolder) => {
    // 題目介面 - 每個題目都創建一個 article、並定義id
    let newArticle = document.createElement("article");
    newArticle.setAttribute("id", `${nowFolder}`) // id為該題目資料夾名稱

    // 將題目加入 main 標籤(主工作區)
    document.querySelector("main").appendChild(newArticle);

    // 題目描述檔裡面各區塊讀取，若為題目或選項呼叫渲染方法
    for (let data of question) {
        if (data.type === "meta") {

        } else if (data.type === "question") {
            // 渲染題目
            renderQuestion(data, nowFolder);
        } else if (data.type === "options") {
            // 渲染選項
            renderOptions(data, nowFolder);
        }
    }

    // 全部完成後呼叫done()，300ms delay
    setTimeout("done()", 300);
}


let renderQuestion = (data, nowFolder) => {

    // 讀取題目類型，共三種: 純文字、純影片、文字 + 影片
    // 1.['word'] 2.['video'] 3."['word', 'video']
    let types = data["question-type"].split(" ")

    const newArticle = document.querySelector(`#${nowFolder}`)
    const numOfThis = nowFolder[1]
    // 例如 nowFolder 為Q「1」，numOfThis 則為 「1」。nowFolder 為Q「2」，numOfThis 則為 「2」
    // numOfThis 可識為題號

    // 依照不同類型渲染
    for (let type of types) {

        if (type === "word") {
            // 純文字渲染，使用 h3 製作題目。 
            let heading = document.createElement("h3");

            // 文字內容: 題號 + 題目文字內容。
            const content = document.createTextNode(`${numOfThis}. ${data["question-content"]}`);
            heading.appendChild(content);

            // 放入題目 article 
            newArticle.appendChild(heading);


        } else if (type === "video") {

            // 影片按鈕 - 定義class、定義按鈕方法(打開影片)、加入文字、放入題目 article
            let videoButton = document.createElement("button");
            videoButton.setAttribute("class", "btn-heading")
            videoButton.setAttribute("onclick", `openVideo("${nowFolder} question")`);
            videoButton.setAttribute("style", "max-width: calc(20%);")
            const content = document.createTextNode(`播放題目`);
            videoButton.appendChild(content);
            newArticle.appendChild(videoButton);
        }
    }

}


let renderOptions = (data, nowFolder) => {

    // 讀取選項類型，共兩種: 純文字、純影片
    let types = data["option-type"].split(" ")
    const newArticle = document.querySelector(`#${nowFolder}`)

    // option - 創建四個選項、使用section標籤、定義id、定義按鈕方法(選擇選項)
    let option1 = document.createElement("section");
    let option2 = document.createElement("section");
    let option3 = document.createElement("section");
    let option4 = document.createElement("section");

    option1.setAttribute("id", `${nowFolder} option1`);
    option2.setAttribute("id", `${nowFolder} option2`);
    option3.setAttribute("id", `${nowFolder} option3`);
    option4.setAttribute("id", `${nowFolder} option4`);

    option1.setAttribute("onclick", `choose("${nowFolder} option1")`);
    option2.setAttribute("onclick", `choose("${nowFolder} option2")`);
    option3.setAttribute("onclick", `choose("${nowFolder} option3")`);
    option4.setAttribute("onclick", `choose("${nowFolder} option4")`);

    for (let type of types) {

        if (type === "word") {
            // 文字渲染

            // 正確選項製作
            const content1 = document.createTextNode(`${data["option-correct"]}`);
            const label1 = document.createElement("label")
            label1.appendChild(content1);
            option1.appendChild(label1);

            // 錯誤選項1製作
            const content2 = document.createTextNode(`${data["option-wrong-1"]}`);
            const label2 = document.createElement("label")
            label2.appendChild(content2);
            option2.appendChild(label2);
            
            
            // 錯誤選項2製作
            const content3 = document.createTextNode(`${data["option-wrong-2"]}`);
            const label3 = document.createElement("label")
            label3.appendChild(content3);
            option3.appendChild(label3);
            
            
            // 錯誤選項3製作
            const content4 = document.createTextNode(`${data["option-wrong-3"]}`);
            const label4 = document.createElement("label")
            label4.appendChild(content4);
            option4.appendChild(label4);

        } else if (type === "video") {

            // 影片按鈕渲染 - 正確選項1
            let videoButton1 = document.createElement("button");
            videoButton1.setAttribute("class", "btn-option")
            videoButton1.setAttribute("onclick", `openVideo("${nowFolder} correct")`);
            videoButton1.setAttribute("style", "max-width: calc(20%);")
            const content1 = document.createTextNode(`播放選項`);
            videoButton1.appendChild(content1);
            option1.appendChild(videoButton1);

            // 影片按鈕渲染 - 錯誤選項1
            let videoButton2 = document.createElement("button");
            videoButton2.setAttribute("class", "btn-option")
            videoButton2.setAttribute("onclick", `openVideo("${nowFolder} wrong-1")`);
            videoButton2.setAttribute("style", "max-width: calc(20%);")
            const content2 = document.createTextNode(`播放選項`);
            videoButton2.appendChild(content2);
            option2.appendChild(videoButton2);
            
            // 影片按鈕渲染 - 錯誤選項2
            let videoButton3 = document.createElement("button");
            videoButton3.setAttribute("class", "btn-option")
            videoButton3.setAttribute("onclick", `openVideo("${nowFolder} wrong-2")`);
            videoButton3.setAttribute("style", "max-width: calc(20%);")
            const content3 = document.createTextNode(`播放選項`);
            videoButton3.appendChild(content3);
            option3.appendChild(videoButton3);
            
            // 影片按鈕渲染 - 錯誤選項3
            let videoButton4 = document.createElement("button");
            videoButton4.setAttribute("class", "btn-option")
            videoButton4.setAttribute("onclick", `openVideo("${nowFolder} wrong-3")`);
            videoButton4.setAttribute("style", "max-width: calc(20%);")
            const content4 = document.createTextNode(`播放選項`);
            videoButton4.appendChild(content4);
            option4.appendChild(videoButton4);
        }
    }


    // 位置打亂 + 增加選項
    let randomOptions = [{
            "option": "A",
            "top": "calc(25% + 10px);"
        },
        {
            "option": "B",
            "top": "calc(42% + 10px);"
        },
        {
            "option": "C",
            "top": "calc(59% + 10px);"
        },
        {
            "option": "D",
            "top": "calc(75% + 10px);"
        },
    ]

    // Array隨機排列
    shuffleArray(randomOptions)

    // 打亂後分給四個選項
    option1.setAttribute("style", `top: ${randomOptions[0].top};`)
    option2.setAttribute("style", `top: ${randomOptions[1].top};`)
    option3.setAttribute("style", `top: ${randomOptions[2].top};`)
    option4.setAttribute("style", `top: ${randomOptions[3].top};`)

    // 選項依照順序增加ABCD
    option1.innerHTML = `<label class="options">(${randomOptions[0].option})</label>` + option1.innerHTML;
    option2.innerHTML = `<label class="options">(${randomOptions[1].option})</label>` + option2.innerHTML;
    option3.innerHTML = `<label class="options">(${randomOptions[2].option})</label>` + option3.innerHTML;
    option4.innerHTML = `<label class="options">(${randomOptions[3].option})</label>` + option4.innerHTML;

    // 將選項加入該題目article中
    newArticle.appendChild(option1);
    newArticle.appendChild(option2);
    newArticle.appendChild(option3);
    newArticle.appendChild(option4);
}

function shuffleArray(inputArray) {
    inputArray.sort(() => Math.random() - 0.5);
}


// 把第一題的Q1的題目字卡顯示
let answer;
let done = () => {
    document.getElementById("Q1").setAttribute("style", "display: block")
    document.querySelector("aside").setAttribute("style", "display: flex")
    answer = new Array(questionNum);
}


let choose = (info) => {
    
    // 存入資料 index為題號 data為該題使用者選擇的選項
    const data = info.split(" ");
    const index = parseInt(data[0][1] - 1)
    
    answer[index] = data[1]

    // 選到的選項 區塊更動顏色
    for (let i = 1; i <= 4; i++) {
        const id = `Q${index + 1} option${i}`
        document.getElementById(id).setAttribute("class", null)
    }
    document.getElementById(info).setAttribute("class", "chosen")
}


// 打開影片播放器，給予打開的題目路徑
let openVideo = (videoData) => {

    videoBox.setAttribute("style", "display: block;")
    const videoPlace = videoData.split(" ");


    video.src = `./questionData/${videoPlace[0]}/${videoPlace[1]}.mp4`;
    // console.log(video.src);
    video.autoplay = true;
    video.setAttribute("controls", "controls")

}

// 關掉影片播放器
let closeVideo = () => {
    videoBox.setAttribute("style", "display: none;")
}

// 呼叫載入function
loadExam();






// 頁碼控制
let nowPage = 1;

let refresh = () => {
    document.getElementById("page").innerHTML = nowPage;
    document.getElementById(`Q${nowPage}`).setAttribute("style", "display: block;");

    if (nowPage === questionNum) {
        document.getElementById("done").setAttribute("style", "display: block;");
    } else {
        document.getElementById("done").setAttribute("style", "display: none;");
    }

}

let doneExam = () => {

}

let prev = () => {
    if (nowPage > 1) {
        document.getElementById(`Q${nowPage}`).setAttribute("style", "display: none;");
        nowPage -= 1;
        refresh();
    }
}

let next = () => {
    if (nowPage < questionNum) {
        document.getElementById(`Q${nowPage}`).setAttribute("style", "display: none;");
        nowPage += 1;
        refresh();
    }
}