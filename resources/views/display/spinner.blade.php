 <div class="carousel-main spinner d-flex flex-wrap align-items-center justify-content-between">
     <div class="cant-decide">
         <h1 class="text-white">{{ $title }}</h1>
         <!-- <h1 class="text-white">Can’t decide what to watch?</h1>
         <span class="text-white">We’ve got you, Spin Now</span> -->
     </div>
     <div class="chart-trigger align-items-center d-flex position-relative">
         <div class="main-chart-spinner d-flex align-items-center">
             <div id="chart"></div>
             <div class="spin-trigger"><img src="{{ asset('assets/img/spin-trigger.svg') }}" alt=""></div>
         </div>
         <div id="question">
             <!-- <h1>Result is shown here</h1> -->
             <div class="spin-img d-flex">
                 <div class="trigger-data-img d-flex">
                     <img src="public/img/dhamal.jpeg" alt="">
                 </div>
             </div>

         </div>
     </div>
 </div>

 <?php
    $temp = [];
    foreach ($value['content'] as $key => $val) {
        $temp[] = [
            'label' => $val['name'],
            'value' => $val['slug'],
            'question' => '',
        ];
    }
    ?>

 <script>
     function onSpinnerError(response) {

         alert('Api error');
     }

     function onSpinnerSuccess(response) {
         $html = '<a href="' + response['payload']['url'] + '"><img src="' + response['payload']['image'] + '"></a>';
         $('.trigger-data-img').html($html);
         console.log('Spinner Success:', responseData);
     }

     function getSpinnerContent($genre) {
         let requestData = {
             genre: $genre
         };
         sendAjaxRequest('{{ route("spinner") }}', 'POST', JSON.stringify(requestData), onSpinnerSuccess, onSpinnerError, 'application/json');
     }

     function activateSpinner() {
         var jsArray = <?php echo json_encode($temp); ?>;

         // SPINER JS START
         var padding = {
                 top: 0,
                 right: 0,
                 bottom: 0,
                 left: 0
             },
             w = 360 - padding.left - padding.right,
             h = 360 - padding.top - padding.bottom,
             r = Math.min(w, h) / 2,
             rotation = 0,
             oldrotation = 0,
             picked = 100000,
             oldpick = [],
             color = d3.scale.category20(); //category20c()

         var data = jsArray;
         var svg = d3.select('#chart')
             .append("svg")
             .data([data])
             .attr("width", w + padding.left + padding.right)
             .attr("height", h + padding.top + padding.bottom);
         var container = svg.append("g")
             .attr("class", "chartholder")
             .attr("transform", "translate(" + (w / 2 + padding.left) + "," + (h / 2 + padding.top) + ")");
         var vis = container
             .append("g");

         var pie = d3.layout.pie().sort(null).value(function(d) {
             return 1;
         });
         // declare an arc generator function
         var arc = d3.svg.arc().outerRadius(r);
         // select paths, use arc generator to draw
         var arcs = vis.selectAll("g.slice")
             .data(pie)
             .enter()
             .append("g")
             .attr("class", "slice");

         arcs.append("path")
             .attr("fill", function(d, i) {
                 return color(i);
             })
             .attr("d", function(d) {
                 return arc(d);
             });
         // add the text
         arcs.append("text").attr("transform", function(d) {
                 d.innerRadius = 0;
                 d.outerRadius = r;
                 d.angle = (d.startAngle + d.endAngle) / 2;
                 return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")translate(" + (d.outerRadius - 10) + ")";
             })
             .attr("text-anchor", "end")
             .text(function(d, i) {
                 return data[i].label;
             });
         container.on("click", spin);

         function spin(d) {

             container.on("click", null);
             //all slices have been seen, all done
             console.log("OldPick: " + oldpick.length, "Data length: " + data.length);
             if (oldpick.length == data.length) {
                 console.log("done");
                 container.on("click", null);
                 return;
             }
             var ps = 360 / data.length,
                 pieslice = Math.round(1440 / data.length),
                 rng = Math.floor((Math.random() * 1440) + 360);

             rotation = (Math.round(rng / ps) * ps);

             picked = Math.round(data.length - (rotation % 360) / ps);
             picked = picked >= data.length ? (picked % data.length) : picked;
             if (oldpick.indexOf(picked) !== -1) {
                 d3.select(this).call(spin);
                 return;
             } else {
                 oldpick.push(picked);
             }
             rotation += 90 - Math.round(ps / 2);
             vis.transition()
                 .duration(3000)
                 .attrTween("transform", rotTween)
                 .each("end", function() {
                     //mark question as seen
                     d3.select(".slice:nth-child(" + (picked + 1) + ") path")
                         .attr("fill", "#111");
                     //populate question
                     d3.select("#question h1")
                         .text(data[picked].question);
                     oldrotation = rotation;

                     /* Get the result value from object "data" */
                     console.log(data[picked].value)
                     // get result
                     getSpinnerContent(data[picked].value);

                     /* Comment the below line for restrict spin to sngle time */
                     container.on("click", spin);
                 });
         }
         //make arrow
         // svg.append("g")
         //     .attr("transform", "translate(" + (w + padding.left + padding.right) + "," + ((h/2)+padding.top) + ")")
         //     .append("path")
         //     .attr("d", "M-" + (r*.15) + ",0L0," + (r*.05) + "L0,-" + (r*.05) + "Z")
         //     .style({"fill":"black"});
         //draw spin circle
         container.append("circle")
             .attr("cx", 0)
             .attr("cy", 0)
             .attr("r", 60)
             .style({
                 "fill": "white",
                 "cursor": "pointer"
             });
         //spin text
         container.append("text")
             .attr("x", 0)
             .attr("y", 6)
             .attr("text-anchor", "middle")
             .text("Spin")
             .style({
                 "font-weight": "bold",
                 "font-size": "20px",
                 "color": "#fff",
                 "cursor": "pointer"
             });


         function rotTween(to) {
             var i = d3.interpolate(oldrotation % 360, rotation);
             return function(t) {
                 return "rotate(" + i(t) + ")";
             };
         }
     }
 </script>