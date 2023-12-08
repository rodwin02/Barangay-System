<?php include "./frontendServer/server.php" ?>
<?php
$query =  "SELECT * FROM tbl_announcement";
$result = $conn->query($query);

$announcement = array();
while($row = $result->fetch_assoc()) {
  $announcement[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
</head>

<body>
    <div class="announcement">
        <div class="announce">
            <h2>Barangay News</h2>
        </div>

        <div class="hide swiper swiperAnnouncement" id="frontendAnnouncement">
            <div class="swiper-wrapper options">
                <?php if(!empty($announcement)) { ?>
                <?php $no=1; foreach($announcement as $row): ?>
                <div class="swiper-slide card">
                    <div class="picture">
                        <img src="./uploads/announcement/<?= $row['image_announcement']?>" alt="image" />
                    </div>

                    <div class="context">
                        <h3>Title</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Velit aliquam iste voluptatibus harum illo, atque voluptatum esse exercitationem ab aliquid corrupti maiores accusantium laborum numquam ex quia dolores excepturi nemo.
                        Optio delectus beatae nemo neque quis, corrupti impedit dolor repellat eos alias voluptatem quod nesciunt aliquam aspernatur? Velit ex alias et eum sunt quis provident, quo ducimus accusantium veritatis autem.</p>

                        <div class="more">
                            <span><?= $row['date_announcement'] ?></span>
                            <a href="./main_announcement.php?id=<?= $row['id'] ?>">Read more ></a>
                        </div>
                    </div>
                </div>
                <?php $no++; endforeach ?>
                <?php } ?>
            </div>

            <img class="swiper-button-prev" src="./assets/arrow-preview.png" alt="arrow-preview" />

            <img class="swiper-button-next" src="./assets/arrow-next.png" alt="arrow-next" />
            <div class="swiper-pagination"></div>
        </div>
    </div>
</body>

</html>