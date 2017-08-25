@foreach($ratings as $rating)
    <hr>
    <div>
        <p class=pull-right>
            {{$rating->created_at}}
        </p>
        <h2>{{$rating->name}}</h2>
        <div class="btn-group">
        @for($i = 1; $i < 6; $i++)
            @if($rating->score >= $i)
                <button type="button" class="btn btn-{{$type[$rating->score]}} btn-xs" aria-label="Left Align">
                    <span style="padding-bottom: 1px;" class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button>
            @else
                <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                    <span style="padding-bottom: 1px;" class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button>
            @endif
        @endfor
        </div>
    </div>
    <p style="font-style: italic; color: #5e5e5e; margin-top: 10px">
    "{{$rating->comment}}"
    </p>
@endforeach