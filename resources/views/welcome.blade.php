<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aerocraft Task</title>

        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            .circle{
                height: 200px;
                border-radius: 50%;
            }
        </style>
    </head>
    <body>
        
        <div class="container my-5">

            <h5 class="text-center my-4">Traffic Light Signal</h5>

            <form action="#" id="trafficLightForm">
                
                @csrf
                
                <div class="row d-flex justify-content-center">
                
                    <div class="col-2 text-center lightBox">
                        <p>A</p>
                        <div class="circle bg-danger"></div>
                        <input type="text" maxlength="1" data-sequence="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->light_one_sequence : 0}}" class="form-control border border-info my-2 numbers_only light_sequence" name="light_one_sequence" value="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->light_one_sequence : ''}}">
                         
                    </div>

                    <div class="col-2 text-center lightBox">
                        <p>B</p>
                        <div class="circle bg-danger"></div>
                        <input type="text" maxlength="1" data-sequence="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->light_two_sequence : 0}}" class="form-control border border-info my-2 numbers_only light_sequence" name="light_two_sequence" value="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->light_two_sequence : ''}}">
                         
                    </div>

                    <div class="col-2 text-center lightBox">
                        <p>C</p>
                        <div class="circle bg-danger"></div>
                        <input type="text" maxlength="1" data-sequence="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->light_three_sequence : 0}}" class="form-control border border-info my-2 numbers_only light_sequence" name="light_three_sequence" value="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->light_three_sequence : ''}}">
                    </div>

                    <div class="col-2 text-center lightBox">
                        <p>D</p>
                        <div class="circle bg-danger"></div>
                        <input type="text" maxlength="1" data-sequence="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->light_four_sequence : 0}}" class="form-control border border-info my-2 numbers_only light_sequence" name="light_four_sequence" value="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->light_four_sequence : ''}}">
                    </div>

                </div>

                <div class="row d-flex justify-content-center">
                
                    <div class="col-8">
                        <div>
                            <span>Green Light Interval</span>
                            <input type="text" class="form-control border border-info my-2 numbers_only" id="greenLightIntvl" name="green_light_interval" value="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->green_light_interval : ''}}">
                        </div>
                        <div>
                            <span>Yellow Light Interval</span>
                            <input type="text" class="form-control border border-info my-2 numbers_only" id="yellowLightIntvl" name="yellow_light_interval" value="{{ !is_null($trafficSignalSetting) ? $trafficSignalSetting->yellow_light_interval : ''}}">
                        </div>
                    </div>

                </div>

                <div class="row d-flex justify-content-center my-4">
                
                    <div class="col-8">
                        <button class="btn btn-primary w-25" type="submit">Start</button>
                        <button class="btn btn-danger w-25" id="stopButton">Stop</button>
                    </div>

                </div>

            </form>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            
            let intervalId;
           
            $(".numbers_only").on('input', function () {
                
                $(this).val($(this).val().replace(/[^0-9]/g,''));

            });

            $(".light_sequence").on('input', function (e) {
                
                let currentValue = $(this).val();
                let isDuplicate = false;
                
                $(".light_sequence").not(this).each(function (e) {

                    if ($(this).val()===currentValue) {
                        
                        isDuplicate = true;

                        return false;
                    }
                
                });

                if (isDuplicate) {
                    
                    alert("This sequence is already added. Please enter a unique value.");

                    $(this).val('');
                
                }else{

                    $(this).attr('data-sequence', currentValue);

                }

            });

            function getStartingLight(seq) {
                
                return $(`input[data-sequence=${seq}]`).closest('.lightBox').find('.circle');
            }

            function updateCircleColor(circle, newColorClass) {
               
                circle.removeClass(function (index, className) {

                    return (className.match(/\bbg-\S+/g) || []).join(' ');
                    
                }).addClass(newColorClass);
            }

            function setAllCircleToRed(){

                $(".circle").each(function () {
                    
                    updateCircleColor($(this), 'bg-danger');

                });
            }

            $("#trafficLightForm").on('submit', function (e) {
                
                e.preventDefault();

                let allFilled = true;
                
                $('.light_sequence').each(function () {
                   
                    if ($(this).val().trim() === '') {

                        allFilled = false;

                        alert('All light sequences must be filled in.'); // As of now i am showing the alert further we can use toast and libraries.
                        
                        return false;
                    }
                    
                });

                if (allFilled) {
                    
                    let index = 0;
                    let greenLightIntvl = parseInt($("#greenLightIntvl").val().trim());
                    let yellowLightIntvl = parseInt($("#yellowLightIntvl").val().trim());

                    if (isNaN(greenLightIntvl) || isNaN(yellowLightIntvl)) {

                        alert('You must have to enter the value of green light interval and yellow light interval.');
                        
                        return;

                    }

                    let lightSequences = $('.light_sequence').map(function (e) {
                        
                        return parseInt($(this).val());

                    }).get().sort((a, b) => a - b); // Sequence data in ASC order.

                    clearInterval(intervalId); // Clear Interval

                    updateLights();

                    intervalId = setInterval(updateLights, (greenLightIntvl + yellowLightIntvl) * 1000);

                    function updateLights() {

                        setAllCircleToRed();

                        let seq = lightSequences[index];

                        let circle = getStartingLight(seq);

                        updateCircleColor(circle, 'bg-success');

                        setTimeout(() => {

                            updateCircleColor(circle, 'bg-warning')
                            
                        }, greenLightIntvl * 1000);

                        index = (index + 1) % lightSequences.length;
                        
                    }

                    let formData = $(this).serialize();

                    $.ajax({
                        url:"{{ route('trafficsignal.store') }}",
                        method:"POST",
                        data:formData,
                        success:function(resp){

                            console.log('RESPONSE DATA: ',resp);

                        },
                        error:function(xhr, status, error){
                            
                            console.log('Error: ', error);

                        }
                    })
                }
            });

            $("#stopButton").on('click', function () {
               
                clearInterval(intervalId);
                return false;

            });

        </script>
    </body>
</html>
