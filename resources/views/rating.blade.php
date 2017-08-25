<?php
    $scores=[
        0,
        $restaurant->star1,
        $restaurant->star2,
        $restaurant->star3,
        $restaurant->star4,
        $restaurant->star5,
        0
    ];

    $scores[6] = $scores[1] + $scores[2] + $scores[3] + $scores[4] + $scores[5];
    if($scores[6] == 0)
        $scores[6] = 1;
?>

<div class="col-md-6">
    <div class="rating-block">
        <h4>Average user rating</h4>
        <h2 class="bold padding-bottom-7">
            @if($restaurant->rating == -1)
                NaN
            @else
                {{number_format($restaurant->rating,2)}}
            @endif
            <small>/ 5</small>
        </h2>

        @for($i = 1; $i < 6; $i++)
            @if($restaurant->rating >= $i)
                <button type="button" class="btn btn-{{$type[$restaurant->rating]}} btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button>
            @else
                <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button>
            @endif
        @endfor
    </div>
</div>

<div class="col-md-6">
    <h4>Rating breakdown</h4>
    @for($i = 1; $i < 6; $i++)
        <div class="pull-left">
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">
                    {{$i}}
                    <span class="glyphicon glyphicon-star"></span>
                </div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-{{$type[$i]}}"
                         role="progressbar" aria-valuenow="5"
                         aria-valuemin="0" aria-valuemax="5"
                         style="width: {{$scores[$i] / $scores[6] * 100}}%">
                    </div>
                </div>
            </div>
            <div class="pull-right" style="margin-left:10px;">{{$scores[$i]}}</div>
        </div>
    @endfor
</div>
