<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Антикафе и события</h2>
    </div>
    <div class="panel-body">
        <button id="check-all" class="btn btn-success btn-lg" type="button">Выбрать все</button>
        <table class="table">
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Тип</th>
                <th>Привязать</th>
            </tr>
            </thead>
            <tbody>
            @forelse($anticafes as $anticafe)
                <tr>
                    <td>{{$anticafe->name}}</td>
                    <td>{{config("types.select.{$anticafe->type}")}}</td>
                    <td class="relative">
                        <input
                                @if(isset($user))
                                {{ !$user->Entities->contains($anticafe->id) ?: "checked"}}
                                @endif
                                name="anticafes[]" type="checkbox" value="{{$anticafe->id}}" class="checkbox">
                        <label for="checkbox"></label>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">В базе данных нет антикафе</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>