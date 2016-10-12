@if ($result->lastPage() > 1)
	<ul class="pagination pull-right">
		<li><a>Showing {{ $result->firstItem() }} - {{ $result->lastItem() }} of {{ $result->total() }} items</a></li>

		@if ($result->currentPage() == 1)
			<li class="disabled"><a href="" aria-label="Previous" disabled="disabled"><span aria-hidden="true">&laquo;</span></a></li>
		@else
			<li><a href="{{ $result->url($result->currentPage()-1) }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
		@endif

		@if ($result->lastPage() > 12)
			@if ($result->currentPage() < 8)
				@for ($i = 1; $i <= 8; $i++)
					<li class="{{ ($result->currentPage() == $i) ? ' active' : '' }}"><a href="{{ $result->url($i) }}">{{ $i }}</a></li>
				@endfor
				<li class="disabled"><a href="" disabled="disabled"><span>...</span></a></li>
				<li><a href="{{ $result->url($result->lastPage()-1) }}">{{ $result->lastPage()-1 }}</a></li>
				<li><a href="{{ $result->url($result->lastPage()) }}">{{ $result->lastPage() }}</a></li>
			@elseif ($result->currentPage() > $result->lastPage() - 8)
				<li><a href="{{ $result->url(1) }}">1</a></li>
				<li><a href="{{ $result->url(2) }}">2</a></li>
				<li class="disabled"><a href="" disabled="disabled"><span>...</span></a></li>
				@for ($i = $result->lastPage()-8; $i <= $result->lastPage(); $i++)
					<li class="{{ ($result->currentPage() == $i) ? ' active' : '' }}"><a href="{{ $result->url($i) }}">{{ $i }}</a></li>
				@endfor
			@else
				<li><a href="{{ $result->url(1) }}">1</a></li>
				<li><a href="{{ $result->url(2) }}">2</a></li>
				<li class="disabled"><a href="" disabled="disabled"><span>...</span></a></li>
				@for($i = max($result->currentPage()-2, 1); $i <= min(max($result->currentPage()-2, 1)+4,$result->lastPage()); $i++)
					<li class="{{ ($result->currentPage() == $i) ? ' active' : '' }}"><a href="{{ $result->url($i) }}">{{ $i }}</a></li>
				@endfor
				<li class="disabled"><a href="" disabled="disabled"><span>...</span></a></li>
				<li><a href="{{ $result->url($result->lastPage()-1) }}">{{ $result->lastPage()-1 }}</a></li>
				<li><a href="{{ $result->url($result->lastPage()) }}">{{ $result->lastPage() }}</a></li>
			@endif
		@else
			@for ($i = 1; $i <= $result->lastPage(); $i++)
				<li class="{{ ($result->currentPage() == $i) ? ' active' : '' }}"><a href="{{ $result->url($i) }}">{{ $i }}</a></li>
			@endfor
		@endif

		@if ($result->currentPage() == $result->lastPage())
			<li class="disabled"><a href="" aria-label="Next" disabled="disabled"><span aria-hidden="true">&raquo;</span></a></li>
		@else
			<li><a href="{{ $result->url($result->currentPage()+1) }}" aria-label="Next" disabled="disabled"><span aria-hidden="true">&raquo;</span></a></li>
		@endif
	</ul>
@endif