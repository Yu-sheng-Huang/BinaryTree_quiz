<!DOCTYPE html>
<html lang="tw">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Binary Tree</title>
<style>
  .node.clickable {
    cursor: pointer;
  }
  .node {
    width: 40px;
    height: 40px;
    border: 1px solid black;
    text-align: center;
    line-height: 40px;
    position: absolute;
  }
  .line {
    border: 1px solid black;
    position: absolute;
  }
  #container {
    position: relative;
    /* margin: 0 auto; */
    margin-right: 450px;
    width: fit-content;

  }
  #top-section {
    width: 100%;
    height: 50%;
    text-align: center;
    padding-top: 20px;
  }

#bottom-section {
  display: flex;
  justify-content: center; /* 水平置中 */
  width: 100%;
  height: 50%;
  text-align: center;
}

</style>
</head>
<body>
<h1>保戶關係查詢</h1>

<!-- 上半部分 -->
<div id="top-section">
  <p>請輸入保戶編號查詢：</p>
  <input type="text" id="searchInput" placeholder="保戶編號">
  <button onclick="searchRelation()">查詢</button>
</div>
<div id="result"></div>
<h1>關係圖</h1>


<div id="bottom-section">
<!-- 用於繪製節點和連線的區域 -->
  <div id="container"></div>
</div>
<script>

function searchRelation(research = null) {
  if(research === null ){
    var searchInput = document.getElementById("searchInput").value;
  }else{
    var searchInput = research;
  }
  // 檢查輸入是否有前導0
  if (searchInput.startsWith('0')) {
    alert("請輸入完整數字，輸入的數字不能為 0 或是以 0 開頭");
    displayResult();
    return; // 停止執行後續操作
  }
  // 檢查輸入是否為數字
  if (!isNaN(searchInput)) {
    var apiUrl = `api/policyholders.php?number='${searchInput}'`;

    fetch(apiUrl).then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    }).then(data => {
      console.log(data);
      drawBinaryTree(data);
    }).catch(error => {
      console.error(error);
      alert('無保戶資料');
    });
  } else {
    alert("請輸入有效的數字！");
  }
}

function displayResult() {
  // 清空
  var resultDiv = document.getElementById("container");
  resultDiv.innerHTML = "";
}

function drawBinaryTree(data) {
  displayResult();
  // 創建節點
  var left = [];
  var right = [];
  if(data != undefined){ // 查詢保戶
    for (const [key, value] of Object.entries(data)) {
        // console.log(`Key: ${key}, Value: ${value}`); 
      if(key == 'l' && value.length != 0){
        // console.log(key ,value);
        for (const [keyl, valuel] of Object.entries(value)) {
          if (!left[keyl]) {
            left[keyl] = {};
          }
          left[keyl]['code']= valuel['code'];
          left[keyl]['name']= valuel['name'];
          left[keyl]['direct']= valuel['direct'];
          // console.log(left);
        }
      }
      if(key == 'r' && value.length != 0){
        // console.log(key ,value);
        for (const [keyr, valuer] of Object.entries(value)) {
          if (!right[keyr]) {
            right[keyr] = {};
          }
          right[keyr]['code']= valuer['code'];
          right[keyr]['name']= valuer['name'];
          right[keyr]['direct']= valuer['direct'];
          // console.log(right);
        }
      }
    }
    // 畫格且創建連線
    if(data != undefined){var node1 = createNode(data['code'],data['name'], 200, 20 , 'first');}
    if(left[0]){ var node2 = createNode(left[0]['code'],left[0]['name'], 100, 90 ,left[0]['direct']);createLine(node1, node2);}
    if(right[0]){ var node3 = createNode(right[0]['code'],right[0]['name'], 300, 90 ,right[0]['direct']);createLine(node1, node3);}
    if(left[1]){ var node4 = createNode(left[1]['code'],left[1]['name'], 50, 160 ,left[1]['direct']); createLine(node2, node4);}
    if(left[2]){ var node5 = createNode(left[2]['code'],left[2]['name'], 150, 160 ,left[2]['direct']); createLine(node2, node5);}
    if(right[1]){ var node6 = createNode(right[1]['code'],right[1]['name'], 250, 160 ,right[1]['direct']); createLine(node3, node6);}
    if(right[2]){ var node7 = createNode(right[2]['code'],right[2]['name'], 350, 160 ,right[2]['direct']); createLine(node3, node7);}
    if(left[3]){ var node8 = createNode(left[3]['code'],left[3]['name'], 25, 230 ,left[3]['direct']); createLine(node4, node8);}
    if(left[4]){ var node9 = createNode(left[4]['code'],left[4]['name'], 75, 230 ,left[4]['direct']); createLine(node4, node9);}
    if(left[5]){ var node10 = createNode(left[5]['code'],left[5]['name'], 125, 230 ,left[5]['direct']); createLine(node5, node10); }
    if(left[6]){ var node11 = createNode(left[6]['code'],left[6]['name'], 175, 230 ,left[6]['direct']); createLine(node5, node11);}
    if(right[3]){ var node12 = createNode(right[3]['code'],right[3]['name'], 225, 230 ,right[3]['direct']); createLine(node6, node12);}
    if(right[4]){ var node13 = createNode(right[4]['code'],right[4]['name'], 225, 230 ,right[4]['direct']); createLine(node6, node13);}
    if(right[5]){ var node14 = createNode(right[5]['code'],right[5]['name'], 325, 230 ,right[5]['direct']); createLine(node7, node14);}
    if(right[6]){ var node15 = createNode(right[6]['code'],right[6]['name'], 375, 230 ,right[6]['direct']); createLine(node7, node15);}
  
  }
}

function createNode(value,name, x, y ,style = null) {
  let node = document.createElement('div');
  node.className = 'node';
  // node.innerText = `<span style="color: blue; text-decoration: underline; cursor: pointer;">${value}</span>` + '\n' + name;
  // 在這裡使用 HTML 標記
  node.innerHTML = `<span style="color: blue; text-decoration: underline; cursor: pointer;">${value}</span>` + '\n' + name;
  node.style.left = x + 'px';
  node.style.top = y + 'px';

  node.addEventListener('click', function() {
    // 獲取 <span> 元素的內容
    let clickedValue = node.querySelector('span').textContent;
    searchRelation(clickedValue);
  });
  node.classList.add('clickable');

  document.getElementById('container').appendChild(node);
  if (style == 'first') {
    node.style.backgroundColor = '#FFFF99';
    // 創建 "上一階" 超連結
    let topNodeLink = document.createElement('a');
    topNodeLink.innerText = '上一階';
    topNodeLink.style.color = 'blue';
    topNodeLink.style.fontSize = 'smaller'; // 調整字體大小
    topNodeLink.style.position = 'relative'; // 指定相對定位
    topNodeLink.style.left = '80px'; // 指定 left 位置
    topNodeLink.style.top = '-80px';
    
    node.appendChild(topNodeLink);
    // 添加超連結的點擊事件處理程序
    topNodeLink.addEventListener('click', function(event) {
        event.stopPropagation(); // 防止點擊節點時也觸發此事件
        let code = value;
        // 發送 GET 請求到 API 端點 Url需轉址
        let apiUrl = routeRequest(`/api/policyholders/${code}/top`);
        // console.log(apiUrl);
        fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            // 在此處發送第二個 API 請求
            let secondaryApiUrl = `api/policyholders.php?number=${data.code}`;
            fetch(secondaryApiUrl)
            .then(response => response.json())
            .then(secondaryData => {
                // 在這裡處理第二個 API 的返回數據
                // console.log(secondaryData);
                drawBinaryTree(secondaryData);
            })
            .catch(error => {
                console.error('Secondary API Error:', error);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
        
  }
  if(style == 'Y'){
    node.style.backgroundColor = '#7FFF7F';
  }
  if(style == 'N'){
    node.style.backgroundColor = '#D3D3D3';
  }
  return node;
}

function createLine(node1, node2) {
  let line = document.createElement('div');
  line.className = 'line';
  let x1 = parseInt(node1.style.left) + node1.offsetWidth / 2;
  let y1 = parseInt(node1.style.top) + node1.offsetHeight;
  let x2 = parseInt(node2.style.left) + node2.offsetWidth / 2;
  let y2 = parseInt(node2.style.top);
  let length = Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
  let angle = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
  line.style.width = length + 'px';
  line.style.height = '1px';
  line.style.left = x1 + 'px';
  line.style.top = y1 + 'px';
  line.style.transformOrigin = 'left';
  line.style.transform = 'rotate(' + angle + 'deg)';
  document.getElementById('container').appendChild(line);
}

// 定義路由轉發函數
function routeRequest(path) {
    if (path.startsWith('/api/policyholders/') && path.endsWith('/top')) {
        // 提取 code 參數
        let code = path.split('/')[3];
        // 返回包含 code 參數的完整路徑
        return `api/topNode.php?code=${code}`;
    } else {
        console.error('Unsupported route:', path);
        return null; // 如果路徑不符合要求，返回 null
    }
}

// drawBinaryTree();
</script>

</body>
</html>
