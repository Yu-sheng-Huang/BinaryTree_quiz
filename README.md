# BinaryTree_quiz
這邊用原生php+javascript+mysql部屬，輸入客戶點查詢後出現一個以該客戶為根節點(root)的2元樹狀圖，上到下共4層，左節點未全滿的情況下優先列在左樹，區分直接介紹客戶(綠色)與間接介紹客戶(灰色)，點root節點下面的其他任一客戶則把該客戶設為根結點再往下展開4層
點根結點旁邊的上一階則回到目前客戶的上一個直接介紹客戶。
1. 客戶查詢API policyholders.php
2. 客戶上層直接關係查詢 topNode.php 點了上一階回到上一個直接介紹客戶
