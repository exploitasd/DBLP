<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
<style type="text/css">

body { 
  font: 14px helvetica neue, helvetica, arial, sans-serif;
}

#cy {
  height: 100%;
  width: 100%;
  position: absolute;
  left: 0;
  top: 0;
}

article {
  background: #fff;
  border: 1px solid #bbb;
  border-radius: 4px;
  width: 160px;
  float: right;
  -webkit-box-shadow: 0px 0px 16px rgba(50, 50, 50, 0.24);
}

.card-header {
  padding: 4px;
  background: #eee;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
  border-bottom: 1px solid #ccc;
}

.card-header button {
  font-size: 13px;
  cursor: pointer;
  width: 100%;
  background: #3498db;
  border: none;
  color: #fff;
  border-radius: 4px;
  padding: 8px;
  -webkit-font-smoothing: antialiased;
}

.card-header button:hover {
  background: #51a7e0;
}

.card-header img {
  width: 152px;
  border-radius: 2px;
}

.card-links {
  list-style: none;
  margin: 0;
  padding: 0;
}

.card-links hr {
  border-bottom: 0;
  border-top: 1px solid #ddd;
  margin: 0;
}

.card-links a {
  text-decoration: none;
  color: #000000;
}

.card-links a li {
  margin: 0;
  padding: 14px 6px;
  border-left: 4px solid #fff;
  transition: background-color 0.2s ease,
              border-left 0.2s ease,
              color 0.2s ease;
}

.card-links a li:hover {
  border-left: 4px solid #3498db;
  background: #f6f6f6;
  color: #44474a;
}

.card-links a li.active {
  border-left: 4px solid #E78584 !important;
  background: #f6f6f6;
  color: #44474a;
}

.card-links a li i {
  position: absolute;
  margin-left: 4px;  
}

.link-favorites {
  border-bottom-left-radius: 4px;
}

.label {
  position: relative;
  left: 26px;
  top: -1px;
  font-size: 12px;
}

.label-notification {
  float: right;
  font-size: 10px;
  color: #8f9496;
  background: #eceded ;
  padding: 4px;
  border-radius: 4px;
  margin: -2px 4px 0 0;
  transition: background-color 0.2s ease, color 0.2s ease;
}

.card-links a li:hover .label-notification,
.label-active {
  color: #44474a;
  background: #d7d9d9;
}

</style>
  
<title>dblp: computer science bibliography</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>
<script src="code.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.min.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.rawgit.com/cytoscape/cytoscape.js-qtip/2.1.0/cytoscape-qtip.js"></script>
</head>
<body>  
  <form method="POST" id='save_graph_form' action='<?php echo base_url(); ?>user/save_graph'>
    <input type="hidden" name="add_db" value='<?php echo $db_add; ?>'>
  </form>
<div id="cy"></div>

 <article>
      <div class="card-header">
        <img class="profile-photo" src="http://www.newstransparency.com/images/placeholder_male.png">
        <p style="text-align:center; font-weight:bold;"><?php echo $this->session->userdata['user']['user_name']; ?> <?php echo $this->session->userdata['user']['user_surname']; ?></p>
        <p style="text-align:center;"><?php echo $this->session->userdata['user']['user_email']; ?></p>
      </div>
      <ul class="card-links">

        <a href="<?php echo base_url(); ?>">
          <li >
            <i class="icon icon-user"></i><span class="label">Dashboard</span>
          </li>
        </a>
        <hr>
         <a href="#" id="save_graph_button">
          <li>
            <i class="icon icon-user"></i><span class="label">Save This Graph</span>
          </li>
        </a>
        <hr>
        <a href="<?php echo base_url(); ?>user/my_graphs">
          <li class="active">
            <i class="icon icon-list-alt"></i><span class="label">Your Graphs</span>
          </li>
        </a>
        <hr>
        <a href="<?php echo base_url() ?>user/logout">
          <li>
            <i class="icon icon-time"></i><span class="label">Logout</span>
          </li>
        </a>
      </ul>
    </article>
</body>
</html>

<script  type="text/javascript" charset="UTF-8">

$("#save_graph_button").on("click",function(){

  $.post($("#save_graph_form").attr('action'),$('#save_graph_form').serialize(),function(status){
    if(status == "1"){
      alert("Graph saved!");
    }
  });
  return false;
});

$(function(){ 

var cy = cytoscape({

  container: document.getElementById('cy'),

  style: cytoscape.stylesheet()
    .selector('node')
      .css({
        'font-size': 10,  
        'content': 'data(gene_name)',
        'text-valign': 'center',
        'color': 'yellow',
        'text-outline-width': 2,
        'text-outline-color': '#888',
        'min-zoomed-font-size': 5,
        'width': 'mapData(score, 0, 1, 20, 50)',
        'height': 'mapData(score, 0, 1, 20, 50)'
      })
    .selector('node:selected')
      .css({
        'background-color': '#000',
        'text-outline-color': '#000'
      })
    .selector('edge')
      .css({
        'curve-style': 'bezier ',
        'opacity': 1,
        'width': 'mapData(normalized_max_weight, 0, 0.01, 1, 20)',
      })
  .selector('edge:selected')
    .css({
      'line-color': 'red'
    }),
  
  elements: cy3json.elements,
  
  layout: {
    name: 'concentric',
    concentric: function(){
      return this.data('score');
    },
    levelWidth: function(nodes){
      return 0.5;
    },
    padding: 10
  }
});

<?php $fg = 0; foreach ($array_xc as $array_x) { ?>
 <?php $nodex = $array_x['nodes']; ?>
 <?php $boook = $array_x['books']; ?>
 <?php for ($l=0; $l < count($nodex)-1; $l++) { ?>
  <?php for ($lx=0; $lx < count($nodex); $lx++) {  ?>
    <?php if($lx>$l){ ?>
    cy.$('#<?php echo $fg; ?><?php echo $l; ?><?php echo $lx; ?>').qtip({
      content: '<?php echo $boook["0"]; ?>',
      position: {
        my: 'top center',
        at: 'bottom center'
      },
      style: {
        classes: 'qtip-bootstrap',
        tip: {
          width: 16,
          height: 8
        }
      }
    });
    <?php } ?>
    <?php } ?>
    <?php } ?>
<?php $fg++; } ?>

}); 

<?php $score_calc = array(); ?>

var cy3json = {
  "format_version" : "1.0",
  "generated_by" : "cytoscape-3.1.0",
  "target_cytoscapejs_version" : "~2.4",
  "data" : {
    "SUID" : 52,
    "source_networks" : "[]",
    "type" : "genemania",
    "attribute_search_limit" : 20,
    "organism" : "H. sapiens",
    "selected" : true,
    "__Annotations" : [ ],
    "name" : "H. sapiens (1)",
    "combining_method" : "automatic",
    "data_version" : "2013-10-15",
    "annotations" : "[]",
    "shared_name" : "H. sapiens (1)",
    "search_limit" : 20
  },

  "elements" : {
    "nodes" : [
    <?php $ih = 0; ?>
    <?php foreach ($authors_list as $authors_node1) { ?>
    <?php echo "{"; ?>
      "<?php echo 'data'; ?>" <?php echo ": {"; ?>
        "<?php echo 'id'; ?>" <?php echo ':' ?> "<?php echo urlencode($authors_node1); ?>" <?php echo ","; ?>
        "<?php echo 'gene_name' ?>" <?php echo ':'; ?> "<?php echo html_entity_decode($authors_node1, ENT_COMPAT, 'UTF-8');?>"
      <?php echo '}'; ?><?php echo ','; ?>
      "<?php echo 'position'; ?>" <?php echo ':' ?> <?php echo '{'; ?>
        "<?php echo 'x' ?>" <?php echo ':'; ?> <?php echo '7.656166076660156'; ?><?php echo ','; ?>
        "<?php echo 'y' ?>" <?php echo ':' ?> <?php echo '-74.6204605102539'; ?>
      <?php echo '}' ?><?php echo ','; ?>
      "<?php echo 'selected'; ?>" <?php echo ':'; ?> <?php echo 'false'; ?>
    <?php echo '}'; ?><?php echo ','; ?>
  <?php } ?> 
],

  "edges" : [ 
        <?php $fg = 0; foreach ($array_xc as $array_x) { 
          $nodex = $array_x['nodes'];
          for ($l=0; $l < count($nodex)-1; $l++) { ?>
           <?php for ($lx=0; $lx < count($nodex); $lx++) { ?> 
            <?php if($lx>$l){ ?>
          { data: { id:"<?php echo $fg; ?><?php echo $l; ?><?php echo $lx; ?>",source: '<?php echo urlencode($nodex[$l]); ?>', target: '<?php echo urlencode($nodex[$lx]); ?>', highlight: 1 } },
          <?php  } ?>
          <?php } ?>
        <?php } ?>
      <?php $fg++; } ?>
    ]
  }
};

</script>    