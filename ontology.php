<?php 
require_once 'template.php';
$title = 'inContext Sensing | SPITFIRE Ontology';
printHeader($title);
?>
</head>
<?php 
$activeMenuItemNum = 3;
$body_onload = '';
$sidebar = '<div class="gadget">
<h2 class="star"><span>What</span></h2>
<div class="clr"></div>
Ontology that leverages already existing ontology (the <a href="www.w3.org/2005/Incubator/ssn/ssnx/ssn">W3C SSN ontology</a>, among others) and ontology design patterns (<a href="http://ontologydesignpatterns.org/wiki/">the Event Model F ones</a>, among others) to enable semantic descriptions of sensors, sensor data, sensor networks, the context around them with a focus on energy saving.
</div>
<div class="gadget">
<h2 class="star"><span>Why</span></h2>
<div class="clr"></div>
The unambiguity and schema-indepenedency features that characterize
RDF, are the key to enable 
<ul>
	<li>plug-and-play sensor nodes</li>
	<li>interoperability among different sensors.</li>
</ul>
Also the context around a sensor observation, can be addressed at any level of granularity and structured according to its mereology, participants and causality features.
</div>';

printBodyTop($activeMenuItemNum, $sidebar, $body_onload);
?>

<h1>The SPITFIRE Ontology</h1>
              <p>
The <span style="font-weight: bold"><a name="top">SPITFIRE Ontology</a></span> (SPT) aligns 
already existing vocabularies to enable the semantic description of, not 
only sensor measurements and sensor metadata, but also of the context 
surrounding them (<a href="#fig1">Figure 1</a>). The ontology also extends them with support for 
energy-efficiency requirements (<a href="#fig2">Figure 2</a> and <a href="#fig3">Figure 3</a>). In particular, the activities sensed by
sensors, are modeled and related with social domain vocabularies and 
complex event descriptions (<a href="#fig4">Figure 4</a>). <br/>

<div style="background-color:#9BD1DB">
The authoritative namespace is <a href="http://spitfire-project.eu/ontology/ns/">http://spitfire-project.eu/ontology/ns/</a> (<a href="http://spitfire-project.eu/ontology.owl">OWL</a>, last update: 30 April 2012) .<br />
The SPITFIRE ontology is 
part of the 
<a href="http://lov.okfn.org/dataset/lov/details/vocabulary_spt.html" target="_blank">
Linked Open Vocabularies</a>. <br />
Browse it using an RDF browser (e.g. 
<a href="http://www5.wiwiss.fu-berlin.de/marbles/?uri=http://spitfire-project.eu/ontology/ns">Marbles</a>, <a href="http://ontorule-project.eu/parrot/parrot?documentUri=http://spitfire-project.eu/ontology/ns">Parrot</a>, <a href="http://www.essepuntato.it/lode/owlapi/http://www.spitfire-project.eu/ontology.owl" target="_blank">LODE</a>).<br />
The <a href="http://purl.oclc.org/NET/ssnx/ssn">W3C Semantic Sensor Network ontology (SSN)</a> constitutes the core of the SPITFIRE ontology.<br />
View all the <a href="http://lov.okfn.org/dataset/lov/details/vocabulary_spt.html">vocabularies referenced by SPT </a>.<br /><br />
</div>

The SPT is composed by the modules showed in <a href="#fig1">Figure 1</a> with a focus on 
<ul>
<li>energy saving in building automation (the <a href="http://spitfire-project.eu">SPITFIRE consolidated use case</a>) thus allowing to monitor and describe both the structure and the performances of sensor networks and their components.</li>
<li>modeling any kind of activity / event that has been sensed together enriched by descriptions of the surrounding environment. The SPITFIRE ontology enables a full and rich description of, not only sensor data but also the sensed event, its structure, what triggered it and its relation with other activities. An activity can be also a Presence somewhere or a Status (either online or offline).</li>
</ul>
<br />
Specific Context-related types and instances are defined in <a href="http://spitfire-project.eu/ontology/ns/ct/">http://spitfire-project.eu/ontology/ns/ct/</a> .<br />
Specific Sensor Network-related types and instances are defined in <a href="http://spitfire-project.eu/ontology/ns/sn/">http://spitfire-project.eu/ontology/ns/sn/</a> .<br />
Specific types and instances related to Places are defined in <a href="http://spitfire-project.eu/ontology/ns/p/">http://spitfire-project.eu/ontology/ns/p/</a> .<br />

<a href="images/onto_modules.jpg" target="_blank"><img src="images/onto_modules.jpg" style="width:600px" /></a><br />
<span style="font-style:italic"><a name="fig1">Figure 1</a>: Modules in which the SPITFIRE vocabulary is divided. For each module the main concepts, predicates and its relation with other modules are depicted, too.</span><br />
<br /><a href="#top">[Top]</a><br/>
<br />
<a href="images/spt-net-components.jpg" target="_blank"><img src="images/spt-net-components.jpg" style="width:600px" /></a><br />
<span style="font-style:italic"><a name="fig2">Figure 2</a>: Data Modeling of the sensor network components. 
Using these terms to profile the network components, is aimed at improving the flexibility of energy-efficient routing algorithm by the addition of semantics.</span><br />
<br /><a href="#top">[Top]</a><br/>
<br />

<a href="images/spt-energy.jpg" target="_blank"><img src="images/spt-energy.jpg" style="width:600px" /></a><br />
<span style="font-style:italic"><a name="fig3">Figure 3</a>: Data Modeling of energy-related concepts.
Using these terms to profile network components or Internet-Connected Objects (ICOs), is aimed at improving the flexibility of energy-efficient routing algorithm by the addition of semantics.</span><br />
<br /><a href="#top">[Top]</a><br/><br />
 

<a href="images/spt-social-provenance.jpg" target="_blank"><img src="images/spt-social-provenance.jpg" style="width:600px" /></a><br />
<span style="font-style:italic"><a name="fig4">Figure 4</a>: Alignment of already existing ontologies from the social, sensor and provenance domain, aimed at further modeling the context surrounding sensors</span><br />
<br /><a href="#top">[Top]</a><br/>


<br /><br /><br />
<br /><br /><br />
<span style="font-weight: bold">Contacts:</span><ul>
<li><a href="http://www.deri.ie/about/team/member/myriam_leggieri" target="_blank">Myriam Leggieri</a>,</li> 
<li><a href = "http://www.deri.ie/about/team/member/michael_hausenblas" target="_blank">Michael Hausenblas</a>.</li>
<li><a href = "http://www.deri.ie/about/team/member/manfred_hauswirth" target="_blank">Manfred Hauswirth</a>.</li>
<li><a href="http://www.deri.ie/about/team/member/alexandre_passant" target="_blank">Alexandre Passant</a>,</li> 
</ul>        
        
<?php 
$copyright_uri = 'http://www.deri.ie';
$copyright_name = 'DERI';
printFooter($copyright_uri, $copyright_name);
?>
 

