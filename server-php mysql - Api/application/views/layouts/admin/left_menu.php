<!--Left Menu-->
<nav>
    <ul class="sidebar-menu" data-widget="tree">
        <li class="sidemenu-user-profile d-flex align-items-center">
            <div class="user-thumbnail">
                <?php
				  if(is_file(APPPATH.'../public/'.$this->session->userdata['file_picture'])&&file_exists(APPPATH.'../public/'.$this->session->userdata['file_picture']))
				   {
				 ?>
					  <img  src="<?php echo base_url().'public/'.$this->session->userdata['file_picture']?>" alt="">
				<?php
					}
					else
					{
				?>
					  <img class="border-radius-50" src="<?php echo base_url()?>public/uploads/no_image.jpg">
				<?php		
					}
				  ?>
            </div>
            <div class="user-content">
                <h6><?php echo $this->session->userdata['first_name']?> <?php echo $this->session->userdata['last_name']?></h6>
                <!--<span>Pro User</span>-->
            </div>
        </li>
        <li <?php if($this->router->fetch_class()=="homecontroller"){?>
					class="active" <?php }?>><a href="<?php echo site_url('homecontroller'); ?>"><i class="icon_lifesaver"></i> <span>Dashboard</span></a></li>
        <?php
		     $menu_open =  false; 
		     if($this->router->fetch_class()=="profile" ||
			    $this->router->fetch_class()=="country" ||
				$this->router->fetch_class()=="company" ||
				$this->router->fetch_class()=="users" 
			 )
			 {
				$menu_open =  true; 
			 }
		?>
        <li class="treeview <?php if($menu_open==true){?>menu-open<?php }?>">
            <a href="javascript:void(0)"><i class="icon_document_alt"></i> <span>Settings</span> <i class="fa fa-angle-right"></i></a>
            <ul class="treeview-menu" <?php if($menu_open==true){?>style="display: block;"<?php }?>>
                <li <?php if($this->router->fetch_class()=="profile"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/profile/index'); ?>">- Profile</a></li>
                <li <?php if($this->router->fetch_class()=="country"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/country/index'); ?>">- Country</a></li>
                <li <?php if($this->router->fetch_class()=="company"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/company/index'); ?>">- Company</a></li>
                <li <?php if($this->router->fetch_class()=="users"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/users/index'); ?>">- Users</a></li>
            </ul>
        </li> 
        <li <?php if($this->router->fetch_class()=="area"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/area/index'); ?>"><i class="icon_table"></i>Area</a></li>
<li <?php if($this->router->fetch_class()=="business"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/business/index'); ?>"><i class="icon_table"></i>Business</a></li>
<li <?php if($this->router->fetch_class()=="location"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/location/index'); ?>"><i class="icon_table"></i>Location</a></li>
<li <?php if($this->router->fetch_class()=="projects"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/projects/index'); ?>"><i class="icon_table"></i>Projects</a></li>
<li <?php if($this->router->fetch_class()=="schedule"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/schedule/index'); ?>"><i class="icon_table"></i>Schedule</a></li>
<li <?php if($this->router->fetch_class()=="schedule_break_details"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/schedule_break_details/index'); ?>"><i class="icon_table"></i>Schedule Break Details</a></li>
<li <?php if($this->router->fetch_class()=="task"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/task/index'); ?>"><i class="icon_table"></i>Task</a></li>
<li <?php if($this->router->fetch_class()=="users_leave"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/users_leave/index'); ?>"><i class="icon_table"></i>Users Leave</a></li>
<li <?php if($this->router->fetch_class()=="users_location"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/users_location/index'); ?>"><i class="icon_table"></i>Users Location</a></li>
<li <?php if($this->router->fetch_class()=="users_pay_details"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/users_pay_details/index'); ?>"><i class="icon_table"></i>Users Pay Details</a></li>
<li <?php if($this->router->fetch_class()=="users_training"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/users_training/index'); ?>"><i class="icon_table"></i>Users Training</a></li>
<li <?php if($this->router->fetch_class()=="users_unavailability"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/users_unavailability/index'); ?>"><i class="icon_table"></i>Users Unavailability</a></li>
<li <?php if($this->router->fetch_class()=="users_works_at_location"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/users_works_at_location/index'); ?>"><i class="icon_table"></i>Users Works At Location</a></li>

    </ul>
</nav>
<!--End of Left Menu//-->