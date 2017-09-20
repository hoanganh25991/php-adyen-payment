<?php
if(count($_POST) > 1){
	var_dump($_POST); die;
}
; ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>Submit form to banker</h1>
<form method="POST" action="https://test.adyen.com/hpp/3d/validate.shtml">
<input type="text" name="PaReq" value="eNpVUcFugzAM/ZWuH0ASaAZFbqSsTFoPMNSxw04TClbLNKANMNp9/RJa1i0nv2f7xX6GbK8RoxdUvUYBMbZtvsNZWazmYRAwThc8WPrMdz26mAtI5RaPAr5Qt2VTC+ZQxwUyQdOu1T6vOwG5Oj5sEsGZ6y2AXBFUqDeRyLDt0qqS6tiXGjWQCw11XqF4le9yfRfKdBM1qp0EGZAxC6rp606fBXcDIBOAXn+KfdcdQkKGYXDy4oy1o5oKiM0Auc2V9jZqjdKpLMRztDslmaRJtuPJ96MXf8RDIse3AmIroMg7FC5lPl1SPqM89HjIfCAjD3llRxDx23bGHUrNphcCDvYfeQHcJv4SYMzWWKuzMO6aNSYEeDo0NZoKY+pvDOQ29PrJWqs6Yxd3rbf83g+WdHJ5TFiV0rjCAhqMMhYAsa3kej9yvbOJ/t3/B8mqq/U=">
<input type="text" name="MD" value="O9Yg+w637bXJTPuUZGhME3+WUssOJy8AX1mwHlf3ERG9etLa32BexHA1dU7gugO7e2QbC8Tjbdl4H53t6HVs2ZGeJoZF2PoxuF3KL+29aeFOcogbTfl/q+kNfTKOuNQre0JP9h9LqO+Wy4PUpzw7Yxxn8Qeqb3E0HSGvqHNKxM4KCJ9ca5FuivNZqVRYPdvjUOgPlDyaFAcOIITIVsp+5HOO6zqCglHi7KuXCtuxxAuHlbygf6V7oXXb8mmBRv9hDDVfJgmsO5ZPInOHCkrMJhBWG+ID8mCc+tLANwR77r8ns/wWwBGkfIDHOKcUJdVJiJZJn3OBSJi5h/yLWOXZAg==">
<input type="text" name="TermUrl" value="https://tinker.press/issuer.php">
</form>
</body>
</html>