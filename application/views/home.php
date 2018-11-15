<?php if($this->session->userdata('logged_in') == FALSE ) {
    //print_r('dfs');
    //die();
    redirect(ROUTES::USER);
}
?>
<h1>User Home</h1>
<?php echo $this->session->userdata('username'); ?> <br>
<a href="<?php echo base_url(ROUTES::USER_LOGOUT);?>">logout</a>