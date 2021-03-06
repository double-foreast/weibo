<li>
  {{-- <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar"/> --}}
  <a href="{{ route('users.show', $user )}}" class="username">{{ $user->name }}</a>

  @can('delete', $user)
    <form action="{{ route('users.destroy', $user) }}" method="post">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
    </form>
  @endcan
</li>
