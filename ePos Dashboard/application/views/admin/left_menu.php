<?php if(!defined("KEY") && $_SESSION['level'] != 1) die("script cannot be accessed directly."); ?>
<?php
$cta = $_GET['cta'];
if($cta == "home") $home = "active"; 
elseif($cta == "facilities") $facilities = "active";
elseif($cta == "events") $events = "active";
elseif($cta == "services") $services = "active";
?>

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav nav2">
            <li class="<?php echo $home; ?>">
                <a href="<?php echo "?cta=home"; ?>">Home</a>
            </li>
            <li class="<?php echo $facilities; ?>">
                <a href="<?php echo "?cta=facilities"; ?>">Facilities</a>
            </li>
            <li class="<?php echo $events; ?>">
                <a href="<?php echo "?cta=events"; ?>">Events</a>
            </li>
            <li class="<?php echo $services; ?>">
                <a href="<?php echo "?cta=services"; ?>">Services</a>
            </li>
        </ul>
    </div>
    
