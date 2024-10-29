<?php
$pageTitle = 'Vending Machine';
ob_start();

$image = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAIEA7QMBIgACEQEDEQH/xAAaAAEBAQEBAQEAAAAAAAAAAAACAAEDBAUH/8QALhABAQEAAgEDAwEFCQAAAAAAAAECAxIRIkJyMoGxBBMxUWLxITRBYXGCkqHR/8QAGQEBAQEBAQEAAAAAAAAAAAAAAQIAAwUE/8QAGxEBAQEBAQADAAAAAAAAAAAAAAERAjESIUH/2gAMAwEAAhEDEQA/APyqhToV6D4RoU6FCljk1xb7Z/q9/Fy55cds/fP8HzqXBeT9rn9l9X/Xj/NpcbrnX0KFOhVuUGjSo0Kg0aVbnPf4ghnPb4jyYd6FbG156yZ7OmsFM+3KcXoye3I6nV6M56DvPY4nXmrtw8Pu19i4uL3a+zq0jXpJjZVJVY2sZlUqgWJJmYkmZtCnQrMNCnQCh8dnr/Tdc+n3a9zzHnTRuvt7aFDj5Pbv7HVuWYNGlW5x3+IUOcd/idKjWGhRpUaDAp8Vz/uCjQp3o0cb7+n3FSGSnK51kvRtbHSj5b5ZWYpU5+Tze7NjalUzMSTMxJMzaFOjWYKzwXhlCgrK2soMLO3fj5Pbv7PHXr/S8OuX1a+n8mDqTHfGO/xdCo10cd0KNKjRTAo0qNSqBRpUaFQK6Y339Puc6NCs16KNHHJ29Ovq/JUjGTXQ5XOsl6M2OlGXo3yNZnbOu7Xnl6O2ddzosakmDEkzNrCo1mGjSo0KgVlbWUGC+p+n5s8uev8AZnWZ9M/d9nz846tmuvqz9R5uJ6nyfToUOHm/a4/m/wAf/Tro45gUaVGiqgUaVGpVAo0qNCoFCnVnHb4hQ4x2dq3wykbo0aVGgsmuh+XKqa6DTh1k10b5GlnoxvuTyTXX1PTjedGVFmNSRBUaVGsw0aVGgwa2ZKZVY6PllVYGbnt29L28XL3x/M8vhnlUuCzXso0ePl7fIqpzzAo0qNSqBRpVZx3Cgzjt8XXwXhlI3Ro0qNBg0S8O2OPr8mw7gThz09X1fhxvF6/U9VCxrBK40aeoFC4L0cXH1+S4+Pr8nQyJtYkikqNKizDWzJSKs2jRpyM3kHXKjSo0Kjc7KuVbnbNheXp4+Xt8nmo+Tos17KNHj5e/yPOe+ynwc47uvgvA04ndGjSo0GDR8F4d+Pj6fJsNuDx8fX5NpUaUhRpUaFBqN4s5+r3MrPIU6pmdd2kMSTAq2ZdKNOJ0ayZOZbWxtAdGGgY57jlXeue4FxyqznuWc9jCtEfBeHq4eHp6tfV+DmpvWDw8PX6vq/BlRqkbrc6VCtzpmxUfB+Hfj4+nybNFuDx8fT5Np0KpG6FGlRoqoFGlRqVhRpUaFQZejtjXdwrJrpsac16UON9yUl3qme5Zz3+JVTlo0KdCsYIaMNJVBoU6FCoyVvgK6fp+TOd+r/l/BjfHo4eHp6tfV+DpUatx3Ro0qNCho0qFCnTi5em3rms7x2w+fW8fJri3+TLg6517qFbnedY7ZZVOcCjSo0VUCjSo1Kwo0qNCoFGlXTj4/dr94w7jOLj6+r3OqSk2vbPoyNSW4jQqQVBDSSVQaFSCoFGpMqPfwf3fH+hVJc8cf2jRqQI0KkFMo1IKd/0fv+zvUlzxy69CjUmrQKNSSsKNSCozP15d0mg6YkiH/9k=";

?>
    <?php if (!empty($products)): ?>
        <div class="d-flex gap-5 vw-100 vh-100 justify-content-center align-items-center flex-wrap py-5">
            <?php
            foreach ($products as $product): ?>
                <a href="#" class="card" style="width: 18rem; height: 300px; text-decoration: none;">
                    <img class="card-img-top" src="<?php  echo $image ?>" alt="Card image cap">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <h6>$ <?php echo htmlspecialchars($product['price']); ?></h6>
                        <p class="card-text"> the bulk of the card's content.</p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
include_once __DIR__ . '/../auth/auth.php';
?>




