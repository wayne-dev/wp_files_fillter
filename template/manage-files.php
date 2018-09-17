<div class="container">
    <div class="container-folder">
        <dl class="dropdown"> 
        <dt>
            <a href="#">
            <span class="hida"><?php _e('Select','sadecweb'); ?></span>    
            <p class="multiSel"></p>  
            </a>
            </dt>
            <dd>
                <div class="mutliSelect">
                </div>
            </dd>
            <button><?php _e('Filter','sadecweb'); ?></button>
        </dl>
    </div>
    <div class="container-files">
    </div>
</div>

<style>
.container-folder .multiSel{
    margin-bottom: 0px;
}
.container-folder .dropdown dd,
.container-folder .dropdown dt {
  margin: 0px;
  padding: 0px;
}
.container-folder .dropdown ul {
  margin: -1px 0 0 0;
}

.container-folder .dropdown dd {
  position: relative;
}
.container-folder .dropdown a,
.container-folder .dropdown a:visited {
  text-decoration: none;
  outline: none;
  font-size: 12px;
}
.container-folder .dropdown dt a {
  display: block;
  padding: 8px 20px 5px 10px;
  min-height: 25px;
  line-height: 24px;
  overflow: hidden;
  border: 1px solid #444;
  width: 100%;
}
.container-folder .dropdown dt a span,
.container-folder .multiSel span {
  cursor: pointer;
  display: inline-block;
  padding: 0 3px 2px 0;
}
.container-folder .dropdown dd ul {
  background: #fff;
  border: 1px solid #444;
  display: none;
  left: 0px;
  padding: 2px 15px 2px 5px;
  position: absolute;
  top: 2px;
  width: 100%;
  list-style: none;
  height: auto;
  overflow: auto;
  z-index: 999;
}
.container-folder .dropdown dd ul li {
    line-height: 30px;
}
.container-folder .dropdown dd ul ul{
    display: block;
    border: 0px;
    position: static;
    padding-left: 10px;
    width: 100%;
    height: auto;
}
.container-folder .dropdown span.value {
  display: none;
}
.container-folder .dropdown dd ul li a {
  padding: 5px;
  display: block;
}
.container-folder .dropdown dd ul li a:hover {
  background-color: #fff;
}
.container-folder button {
  background-color: #ce0505;
  width: 100%;
  border: 0;
  padding: 10px 0;
  margin: 5px 0;
  text-align: center;
  color: #fff;
  font-weight: bold;
}
.container-files > ul {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
}
.container-files > ul li{
    width: 100px;
    max-width: 80%;
}
.container-files > ul li div{
    text-align: center;
}
.container-files > ul li img{
    padding-bottom: 10px;
}
</style>