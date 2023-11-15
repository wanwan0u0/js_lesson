<body style="background-color: white;">
    <header style="background: black;">
    </header>

<html>
<head>
  <link rel="stylesheet" href="upload_style.css?v=<?=time()?>">
  <script src="https://kit.fontawesome.com/ad45004b60.js" crossorigin="anonymous"></script>

</head>
<body>
<?php
if(!empty($_FILES["art"]["tmp_name"])){
    copy($_FILES["art"]["tmp_name"],$_FILES['art']['name']);
    unlink($_FILES["art"]["tmp_name"]);
    $artwork_file=$_FILES['art']['name'];
    print($artwork_file);
}
else{
    $artwork_file="0";
}
?>
<div class="upload-container">
<button id="test" style="display:none"></button>
<button onclick="average()" id="blured">均值濾波</button>
<button onclick="Gaussian()" id="blured">高斯濾波</button>
<button onclick="mid_9()" id="blured">中值濾波3*3</button>
<button onclick="mid_25()" id="blured">中值濾波5*5</button>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" onchange="readURL(this)" id="button" targetID="preview_tmp_img" name="art" accept="image/png,image/jpeg,image/jpg" required="required"></br>
  <hr width="89%" color="#dddddd">
    </br>
    <div class="big_image-container">
    <div class="image-container">
    <i class="fa-solid fa-image" style="color: #4e72b1;"></i>image:
    <img src="#" id="preview_tmp_img" class="img-block" style="display:none"></img>
    </div>

    <div class="image-container">
    <i class="fa-solid fa-image" style="color: #4e72b1;"></i>image:</br>
    <canvas src="#" class="img-block"  id="blur"style="display:none"></canvas>
    </div>
    </div>
  </form>
</div>
</body>
<script>
    function readURL(input){
      if(input.files && input.files[0]){
        var imageTagID = input.getAttribute("targetID");
        var reader = new FileReader();
        reader.onload = function (e) {
           var img = document.getElementById(imageTagID);
           img.setAttribute("src", e.target.result)
           img.src=e.target.result;
        }
        a=reader.readAsDataURL(input.files[0]);
      }
      document.getElementById('test').click()
    }

    function average(){
        var iCanvas = document.getElementById("blur");
        var imgBlur = new imageBlur(iCanvas, document.getElementById("preview_tmp_img").src, "BORDER_REPLICATE", "right", "blur");
        imgBlur.render();
    }
    function Gaussian(){
        var iCanvas = document.getElementById("blur");
        var imgBlur = new imageBlur(iCanvas, document.getElementById("preview_tmp_img").src, "BORDER_REPLICATE", "right", "GaussianBlur");
        imgBlur.render();
    }
    function mid_9(){
        var iCanvas = document.getElementById("blur");
        var imgBlur = new imageBlur(iCanvas, document.getElementById("preview_tmp_img").src, "BORDER_REPLICATE", "right", "median 3*3");
        imgBlur.render();
    }
    function mid_25(){
        var iCanvas = document.getElementById("blur");
        var imgBlur = new imageBlur(iCanvas, document.getElementById("preview_tmp_img").src, "BORDER_REPLICATE", "right", "median 5*5");
        imgBlur.render();
    }
function style(elem, prop) {
    return window.getComputedStyle(elem, null)[prop];
}

function show(elem) {
    elem.style.display = elem.previousDisplay || '';
    if(style(elem, 'display') === 'none') {
        // 在 DOM 樹上建立元素，取得 display 預設值後移除
        let node = document.createElement(elem.nodeName);
        document.body.appendChild(node);
        elem.style.display = style(node, 'display');
        document.body.removeChild(node);
    }
}
  document.getElementById('test').onclick = function() {
      let original_image = document.getElementById('preview_tmp_img');
      let blur_image = document.getElementById('blur');
      if(style(original_image, 'display') === 'none') {
          show(original_image);
      }
      if(style(blur_image, 'display') === 'none') {
          show(blur_image);
      }
    };


(function () {
    function imageBlur(iCanvas, url, borderType, orientation, blurType, value) {
        this.canvas = iCanvas;
        this.iCtx = this.canvas.getContext("2d");
        this.url = url;
        this.borderType = borderType;
        this.orientation = orientation || "bottom";
        this.value = value || [0, 0, 0, 255];
        this.blurType = blurType || "blur";
    }

    imageBlur.prototype = {
        imread: function (_image) {
            var width = _image.width,
                height = _image.height;
            this.iResize(width, height);
            this.iCtx.drawImage(_image, 0, 0);
            var imageData = this.iCtx.getImageData(0, 0, width, height),
                tempMat = new Mat(height, width, imageData.data);
            imageData = null;
            this.iCtx.clearRect(0, 0, width, height);
            return tempMat;
        },
        iResize: function (_width, _height) {
            this.canvas.width = _width;
            this.canvas.height = _height;
        },
        RGBA2ImageData: function (_imgMat) {
            var width = _imgMat.col,
                height = _imgMat.row;
            var imageData = this.iCtx.createImageData(width, height);
            imageData.data.set(_imgMat.data);
            return imageData;
        },
        render: function () {
            var img = new Image();
            var _this = this;
            img.onload = function () {
                var myMat = _this.imread(img);
                var newImage = null;
                if (_this.blurType == "blur") {
                    newImage = blur(myMat, 3, 3, _this.borderType);
                } else if (_this.blurType == "median 3*3") {
                    newImage = medianBlur(myMat, 3, 3, _this.borderType);
                } else if (_this.blurType == "median 5*5") {
                    newImage = medianBlur(myMat, 5, 5, _this.borderType);
                } else {
                    newImage = GaussianBlur(myMat, 3, 3, 0, 0, _this.borderType);
                }
                var newIamgeData = _this.RGBA2ImageData(newImage);
                _this.iCtx.putImageData(newIamgeData, 0, 0);
            };
            img.src = this.url;
        }
    };

    function Mat(_row, _col, _data, _buffer) {
        this.row = _row || 0;
        this.col = _col || 0;
        this.channel = 4;
        this.buffer = _buffer || new ArrayBuffer(_row * _col * 4);
        this.data = new Uint8ClampedArray(this.buffer);
        _data && this.data.set(_data);
        this.bytes = 1;
        this.type = "CV_RGBA";
    }

    function blur(__src, __size1, __size2, __borderType, __dst) {
        if (__src.type && __src.type == "CV_RGBA") {
            var height = __src.row,
                width = __src.col,
                dst = __dst || new Mat(height, width, __src.data),
                dstData = dst.data;
            var size1 = __size1 || 3,
                size2 = __size2 || size1,
                size = size1 * size2;
            if (size1 % 2 !== 1 || size2 % 2 !== 1) {
                console.error("size必須是奇數");
                return __src;
            }
            var startX = Math.floor(size1 / 2),
                startY = Math.floor(size2 / 2);
            var withBorderMat = copyMakeBorder(__src, startY, startX, 0, 0, __borderType),
                mData = withBorderMat.data,
                mWidth = withBorderMat.col;

            var newValue, nowX, offsetY, offsetI;
            var i, j, c, y, x;

            for (i = height; i--;) {
                offsetI = i * width;
                for (j = width; j--;) {
                    for (c = 3; c--;) {
                        newValue = 0;
                        for (y = size2; y--;) {
                            offsetY = (y + i) * mWidth * 4;
                            for (x = size1; x--;) {
                                nowX = (x + j) * 4 + c;
                                newValue += mData[offsetY + nowX];
                            }
                        }
                        dstData[(j + offsetI) * 4 + c] = newValue / size;
                    }
                    dstData[(j + offsetI) * 4 + 3] = mData[offsetY + startY * mWidth * 4 + (j + startX) * 4 + 3];
                }
            }

        } else {
            console.error("不支持的類型");
        }
        return dst;
    }

    function getGaussianKernel(__n, __sigma) {
        var SMALL_GAUSSIAN_SIZE = 7,
            smallGaussianTab = [[1],
                                [0.25, 0.5, 0.25],
                                [0.0625, 0.25, 0.375, 0.25, 0.0625],
                                [0.03125, 0.109375, 0.21875, 0.28125, 0.21875, 0.109375, 0.03125]
            ];

        var fixedKernel = __n & 2 == 1 && __n <= SMALL_GAUSSIAN_SIZE && __sigma <= 0 ? smallGaussianTab[__n >> 1] : 0;

        var sigmaX = __sigma > 0 ? __sigma : ((__n - 1) * 0.5 - 1) * 0.3 + 0.8,
            scale2X = -0.5 / (sigmaX * sigmaX),
            sum = 0;

        var i, x, t, kernel = [];

        for (i = 0; i < __n; i++) {
            x = i - (__n - 1) * 0.5;
            t = fixedKernel ? fixedKernel[i] : Math.exp(scale2X * x * x);
            kernel[i] = t;
            sum += t;
        }

        sum = 1 / sum;

        for (i = __n; i--;) {
            kernel[i] *= sum;
        }

        return kernel;
    };

    function GaussianBlur(__src, __size1, __size2, __sigma1, __sigma2, __borderType, __dst) {
        if (__src.type && __src.type == "CV_RGBA") {
            var height = __src.row,
                width = __src.col,
                dst = __dst || new Mat(height, width, __src.data),
                dstData = dst.data;
            var sigma1 = __sigma1 || 0,
                sigma2 = __sigma2 || __sigma1;
            var size1 = __size1 || Math.round(sigma1 * 6 + 1) | 1,
                size2 = __size2 || Math.round(sigma2 * 6 + 1) | 1,
                size = size1 * size2;
            if (size1 % 2 !== 1 || size2 % 2 !== 1) {
                console.error("size必須是奇數");
                return __src;
            }
            var startX = Math.floor(size1 / 2),
                startY = Math.floor(size2 / 2);
            var withBorderMat = copyMakeBorder(__src, startY, startX, 0, 0, __borderType),
                mData = withBorderMat.data,
                mWidth = withBorderMat.col;

            var kernel1 = getGaussianKernel(size1, sigma1),
                kernel2,
                kernel = new Array(size1 * size2);

            if (size1 === size2 && sigma1 === sigma2)
                kernel2 = kernel1;
            else
                kernel2 = getGaussianKernel(size2, sigma2);

            var i, j, c, y, x;

            for (i = kernel2.length; i--;) {
                for (j = kernel1.length; j--;) {
                    kernel[i * size1 + j] = kernel2[i] * kernel1[j];
                }
            }

            var newValue, nowX, offsetY, offsetI;

            for (i = height; i--;) {
                offsetI = i * width;
                for (j = width; j--;) {
                    for (c = 3; c--;) {
                        newValue = 0;
                        for (y = size2; y--;) {
                            offsetY = (y + i) * mWidth * 4;
                            for (x = size1; x--;) {
                                nowX = (x + j) * 4 + c;
                                newValue += (mData[offsetY + nowX] * kernel[y * size1 + x]);
                            }
                        }
                        dstData[(j + offsetI) * 4 + c] = newValue;
                    }
                    dstData[(j + offsetI) * 4 + 3] = mData[offsetY + startY * mWidth * 4 + (j + startX) * 4 + 3];
                }
            }

        } else {
            console.error("不支持的類型");
        }
        return dst;
    }

    function medianBlur(__src, __size1, __size2, __borderType, __dst) {
        if (__src.type && __src.type == "CV_RGBA") {
            var height = __src.row,
                width = __src.col,
                dst = __dst || new Mat(height, width, __src.data),
                dstData = dst.data;
            var size1 = __size1 || 3,
                size2 = __size2 || size1,
                size = size1 * size2;
            if (size1 % 2 !== 1 || size2 % 2 !== 1) {
                console.error("size必須是奇數");
                return __src;
            }
            var startX = Math.floor(size1 / 2),
                startY = Math.floor(size2 / 2);
            var withBorderMat = copyMakeBorder(__src, startY, startX, 0, 0, __borderType),
                mData = withBorderMat.data,
                mWidth = withBorderMat.col;

            var newValue = [], nowX, offsetY, offsetI;
            var i, j, c, y, x;

            for (i = height; i--;) {
                offsetI = i * width;
                for (j = width; j--;) {
                    for (c = 3; c--;) {
                        for (y = size2; y--;) {
                            offsetY = (y + i) * mWidth * 4;
                            for (x = size1; x--;) {
                                nowX = (x + j) * 4 + c;
                                newValue[y * size1 + x] = mData[offsetY + nowX];
                            }
                        }
                        newValue.sort(function(a,b){return a-b})
                        dstData[(j + offsetI) * 4 + c] = newValue[Math.round(size / 2)-1];
                    }
                    dstData[(j + offsetI) * 4 + 3] = mData[offsetY + startY * mWidth * 4 + (j + startX) * 4 + 3];
                }
            }

        } else {
            console.error("不支持的類型");
        }
        return dst;
    };

    function copyMakeBorder(_src, _top, _left, _bottom, _right, _borderType, _value) {
        if (_src.type != "CV_RGBA") {
            console.log("not support this type");
        } else if (_borderType == "BORDER_CONSTANT") {
            return copyMakeConstBorder_8U(_src, _top, _left, _bottom, _right, _value);
        } else {
            return copyMakeBorder_8U(_src, _top, _left, _bottom, _right, _borderType);
        }
    }

    function borderInterpolate(_p, _len, _borderType) {
        if (_p < 0 || _p >= _len) {
            switch (_borderType) {
                case "BORDER_REPLICATE":
                    _p = _p < 0 ? 0 : _len - 1;
                    break;
                case "BORDER_REFLECT":
                case "BORDER_REFLECT_101":
                    var delta = (_borderType == "BORDER_REFLECT_101");
                    if (_len == 1) {
                        return 0;
                    }
                    do {
                        if (_p < 0) {
                            _p = -_p - 1 + delta;
                        } else {
                            _p = _len - 1 - (_p - _len) - delta;
                        }
                    } while (_p < 0 || _p >= _len);
                    break;
                case "BORDER_WRAP":
                    if (_p < 0) {
                        _p -= ((_p - _len + 1) / _len | 0) * _len;
                    }
                    if (_p >= _len) {
                        _p %= _len;
                    }
                    break;
                case "BORDER_CONSTANT":
                    _p = -1;
                default:
                    console.log(arguments.callee, "UNSPPORT_BORDER_TYPE");
            }
        }
        return _p;
    }

    function copyMakeBorder_8U(_src, _top, _left, _bottom, _right, _borderType) {
        var i, j;
        var width = _src.col,
            height = _src.row;
        var top = _top,
            left = _left || _top,
            right = _right || left,
            bottom = _bottom || top,
            dstWidth = width + left + right,
            dstHeight = height + top + bottom,
            borderType = _borderType || "BORDER_REFLECT";
        var buffer = new ArrayBuffer(dstHeight * dstWidth * 4),
            tab = new Uint32Array(left + right);

        for (i = 0; i < left; i++) {
            tab[i] = borderInterpolate(i - left, width, borderType);
        }
        for (i = 0; i < right; i++) {
            tab[i + left] = borderInterpolate(width + i, width, borderType);
        }

        var tempArray, data;

        for (i = 0; i < height; i++) {
            tempArray = new Uint32Array(buffer, (i + top) * dstWidth * 4, dstWidth);
            data = new Uint32Array(_src.buffer, i * width * 4, width);
            for (j = 0; j < left; j++)
                tempArray[j] = data[tab[j]];
            for (j = 0; j < right; j++)
                tempArray[j + width + left] = data[tab[j + left]];
            tempArray.set(data, left);
        }

        var allArray = new Uint32Array(buffer);
        for (i = 0; i < top; i++) {
            j = borderInterpolate(i - top, height, _borderType);
            tempArray = new Uint32Array(buffer, i * dstWidth * 4, dstWidth);
            tempArray.set(allArray.subarray((j + top) * dstWidth, (j + top + 1) * dstWidth));
        }
        for (i = 0; i < bottom; i++) {
            j = borderInterpolate(i + height, height, borderType);
            tempArray = new Uint32Array(buffer, (i + top + height) * dstWidth * 4, dstWidth);
            tempArray.set(allArray.subarray((j + top) * dstWidth, (j + top + 1) * dstWidth));
        }

        return new Mat(dstHeight, dstWidth, new Uint8ClampedArray(buffer));
    }

    function copyMakeConstBorder_8U(_src, _top, _left, _bottom, _right, _value) {
        var i, j;
        var width = _src.col,
            height = _src.row;
        var top = _top,
            left = _left || _top,
            right = _right || left,
            bottom = _bottom || top,
            dstWidth = width + left + right,
            dstHeight = height + top + bottom,
            value = _value || [0, 0, 0, 255];
        var constBuf = new ArrayBuffer(dstWidth * 4),
            constArray = new Uint8ClampedArray(constBuf);
        buffer = new ArrayBuffer(dstHeight * dstWidth * 4);

        for (i = 0; i < dstWidth; i++) {
            for (j = 0; j < 4; j++) {
                constArray[i * 4 + j] = value[j];
            }
        }

        constArray = new Uint32Array(constBuf);
        var tempArray;

        for (i = 0; i < height; i++) {
            tempArray = new Uint32Array(buffer, (i + top) * dstWidth * 4, left);
            tempArray.set(constArray.subarray(0, left));
            tempArray = new Uint32Array(buffer, ((i + top + 1) * dstWidth - right) * 4, right);
            tempArray.set(constArray.subarray(0, right));
            tempArray = new Uint32Array(buffer, ((i + top) * dstWidth + left) * 4, width);
            tempArray.set(new Uint32Array(_src.buffer, i * width * 4, width));
        }

        for (i = 0; i < top; i++) {
            tempArray = new Uint32Array(buffer, i * dstWidth * 4, dstWidth);
            tempArray.set(constArray);
        }

        for (i = 0; i < bottom; i++) {
            tempArray = new Uint32Array(buffer, (i + top + height) * dstWidth * 4, dstWidth);
            tempArray.set(constArray);
        }

        return new Mat(dstHeight, dstWidth, new Uint8ClampedArray(buffer));
    }

    window.imageBlur = imageBlur;
})();
</script>
</html>
