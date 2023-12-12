<?php include './server/server.php'?>
<?php
$query =  "SELECT * FROM tbl_announcement";
$result = $conn->query($query);

$announcement = array();
while($row = $result->fetch_assoc()) {
  $announcement[] = $row;
}   

// $id = $_GET['id'];
// $query2 =  "SELECT image_announcement FROM tbl_announcement WHERE `id`='$id'";
// $result2 = $conn->query($query2);
// $imageAnn = $result2->fetch_assoc();
// echo $imageAnn;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <link rel="stylesheet" href="style3.css ?<?php echo time(); ?> ">
    <link rel="stylesheet" href="style4.css ?<?php echo time(); ?> ">
    <link rel="stylesheet" href="sidenav.css ">
    <link rel="stylesheet" href="./style/generateCert.css">
    <script src="sidebar.js "></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>

<body>
    <?php include './model/fetch_brgy_role.php' ?>
    <?php include './actives/active_restore.php' ?>
    <?php include './actives/active_account.php' ?>
    <?php include './sidebar.php' ?>


    <!-- START BODY -->
    <div class="body-cont">
        <div class="first-layer">
            <p>Announcement</p>
           
        </div>

        <div class="second_layer">
            <div class="search-cont">
                <p>Search:</p>
                <input type="text" class="searchBar" placeholder=" Enter text here">
            </div>
            <div class="add-cont">
                <a href="#" class="addAnnouncement" id="addAnnouncement">+ Announcement</a>
                <a href="archives/ArchiveAnnouncement.php" class="archiveResidents">Archive</a>
            </div>
        </div>

        <div class="Swiper_anouncement">
        <!-- Swiper -->
           <div class="swiper swiper-container">
                <div class="swiper-wrapper">
                    <?php if(!empty($announcement)) { ?>
                    <?php $no=1; foreach($announcement as $row):
                            $dateTime = new DateTime($row['date_announcement']);
                            $formattedDate = $dateTime->format('Y-m-d'); // Format as date (year-month-day)
                     ?>
                        <div class="one-announcement swiper-slide">
                            <img src="./uploads//announcement/<?= $row['image_announcement']?>" alt="announcement-image">
                            <div class="date"><?= $formattedDate?></div>
                            <div class="title"><?= $row['title'] ?></div>
                            <a href="#" id="editAnnouncement" class="editAnnouncement"
                            onclick="editAnnouncementSys(this)"
                            data-id="<?= $row['id']?>"
                            data-title="<?= $row['title']?>"
                            data-details="<?= $row['details']?>"
                            data-date_announcement="<?= $row['date_announcement']?>"
                            data-image_announcement="<?= $row['image_announcement']?>"
                            data-begin_date="<?= $row['begin_date']?>"
                            data-until_date="<?= $row['until_date']?>"
                            >Edit</a> 
                            <a href="#" class="delete">Delete</a>

                        </div>

                            <div class="modal-delete">
                                <div class="form-delete">
                                    <div class="delete-cont">
                                        <p>Delete</p>
                                        <img src="iconsBackend/close 1.png" alt="" class="close-delete">
                                    </div>
                                    <div class="delete-description">
                                        <p>Deleting this will remove all data
                                            and cannot be undone.</p>
                                    </div>
                                    <div class="delete-submit">
                                        <a href="./model/remove/remove_announcement.php?id=<?= $row['id'] ?>">Delete</a>
                                    </div>
                                </div>
                            </div>
                        
                    <?php $no++; endforeach ?>
                    <?php } ?>
                </div>
              <!-- Add Pagination -->
              <div class="swiper-pagination"></div>
           </div>
        </div>
    </div>
   
    <!-- END BODY -->

    <!-- START MODAL ANNOUNCEMENT -->
    <div class="modal-addAnnouncement">
        <form class="formAnnouncement" action="./model/add_announcement.php" method="post"
            enctype="multipart/form-data">
            <div class="title-container">
                <p>Create Announcement</p>
                <img src="iconsBackend/close 1.png" class="closeAnnouncement" alt="">
            </div>

            <div class="information-cont-line">
                <p>Announcement Infomration</p>
                <div class="line"></div>
            </div>

            <div class="input-announcement-cont">
                <div class="title-date-cont">
                    <div class="title-cont">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" required>
                    </div>
                    <!-- <div class="date-cont">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date">
                    </div> -->
                </div>
                
                <div class="details-cont">
                    <label for="details">Details</label>
                    <textarea name="details" id="details" cols="30" rows="10"></textarea>

                    <p class="upload">Upload Photo:</p>
                    <label for="image" class="image">
                    <input type="file" name="image_announcement" id="image">
                    </label>
                </div>
            </div>

            <div class="information-cont-line">
                <p>Announcement Option</p>
                <div class="line1"></div>
            </div>

            <div class="option-cont">
                <p>Duration</p>
                <div class="timer-cont">
                    <div class="from-cont">
                        <label for="from">Show From</label>
                        <input type="date" name="begin_date" id="from">
                    </div>
                    <div class="until-cont">
                        <label for="until">Show Until</label>
                        <input type="date" name="end_date" id="until">
                    </div>
                </div>
            </div>

            <input class="submitAnnouncement" type="submit" value="Submit">
        </form>
    </div>
    <!-- END MODAL ANNOUNCEMENT -->


    <!-- START EDIT MODAL ANNOUNCEMENT -->
    <div class="modal-editAnnouncement">
        <form class="formAnnouncement" action="./model/edit_announcement.php" method="post" enctype="multipart/form-data">
            <div class="title-container">
                <p>Edit Announcement</p>
                <img src="iconsBackend/close 1.png" class="closeAnnouncementEdit" alt="">
            </div>

            <div class="information-cont-line">
                <p>Announcement Infomration</p>
                <div class="line"></div>
            </div>

            <div class="input-announcement-cont">
                <div class="title-date-cont">
                    <div class="title-cont">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title1">
                    </div>
                    <!-- <div class="date-cont1">
                        <label for="date">Date</label>
                        <input type="date" id="date1">
                    </div> -->
                </div>
                
                <div class="details-cont">
                    <label for="details">Details</label>
                    <textarea name="details" name="details" id="details1" cols="30" rows="10"></textarea>

                    <p class="upload">Upload Photo:</p>
                    <label for="image" class="image">
                    <input type="file" name="image_announcement" id="image1">
                    </label>
                </div>
            </div>

            <div class="information-cont-line">
                <p>Announcement Option</p>
                <div class="line1"></div>
            </div>

            <div class="option-cont">
                <p>Duration</p>
                <div class="timer-cont">
                    <div class="from-cont">
                        <label for="from">Show From</label>
                        <input type="date" name="begin_date" id="from1">
                    </div>
                    <div class="until-cont">
                        <label for="until">Show Until</label>
                        <input type="date" name="until_date" id="until1">
                    </div>
                </div>
            </div>

            <input type="hidden" name="date_announcement" id="date1">
            <input type="hidden" name="id" id="announcement_id">
            <input class="submitAnnouncement" type="submit" value="Submit">
        </form>
    </div>
    <!-- END EDIT MODAL ANNOUNCEMENT -->    

    <script src="./js//jQuery-3.7.0.js"></script>
    <script src="./js//app.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
     var swiper = new Swiper('.swiper-container', {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            600: {
                slidesPerView: 2,
            },
            900: {
                slidesPerView: 3,
            },
        },
    });
    </script>
</body>

</html>

<script>

const addAnnouncement = document.getElementById('addAnnouncement');
const modalAnnouncement = document.querySelector('.modal-addAnnouncement');
const closeAnnouncement = document.querySelector('.closeAnnouncement');

addAnnouncement.addEventListener('click', function(event) {
    event.preventDefault();
    modalAnnouncement.style.display = 'block';
});

closeAnnouncement.addEventListener('click', function() {
    modalAnnouncement.style.display = 'none';
});

const editAnnouncement = document.querySelectorAll('.editAnnouncement');
const modalAnnouncementEdit = document.querySelector('.modal-editAnnouncement');
const closeAnnouncementEdit = document.querySelector('.closeAnnouncementEdit');

editAnnouncement.forEach(edit => {
    edit.addEventListener('click', function(event) {
        event.preventDefault();
        modalAnnouncementEdit.style.display = 'block';
    });
    
    closeAnnouncementEdit.addEventListener('click', function() {
        modalAnnouncementEdit.style.display = 'none';
    });
})

// Get the file input element and the preview image element
const fileInput = document.getElementById("image");
const imagePreview = document.getElementById("preview");

// Add an event listener to the file input
fileInput.addEventListener("change", function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    // Read the selected file as a data URL and set it as the preview image source
    reader.onload = function(e) {
        imagePreview.src = e.target.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    }
});


// JavaScript code to handle pagination
const table = document.getElementById('table');
const rows = table.querySelectorAll('tbody tr');
const totalRows = rows.length;
const rowsPerPage = 10;
let currentPage = 1;

function showRows(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    rows.forEach((row, index) => {
        if (index >= start && index < end) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
}

function updatePaginationButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pageNumbers = document.getElementById('pageNumbers');

    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === Math.ceil(totalRows / rowsPerPage);

    pageNumbers.textContent = currentPage;
}

// Initial setup
showRows(currentPage);
updatePaginationButtons();

// Previous button click event
document.getElementById('prevBtn').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        showRows(currentPage);
        updatePaginationButtons();
    }
});
</script>

<script>
    // DELETE RESIDENTS
    const deleteLink = document.querySelectorAll('.delete');
    const modalDelete = document.querySelectorAll('.modal-delete');
    const closeButtonDelete = document.querySelectorAll('.close-delete');

    deleteLink.forEach((del, index) => {
    del.addEventListener('click', (e) => {
    console.log("Delete link clicked")
    modalDelete[index].style.display = 'block';
    });

    closeButtonDelete[index].addEventListener('click', function() {
    modalDelete[index].style.display = 'none';
    });
    })
</script>
