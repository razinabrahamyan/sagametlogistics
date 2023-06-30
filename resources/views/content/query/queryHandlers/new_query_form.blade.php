<form action="{{route('storeQuery')}}" method="POST" enctype="multipart/form-data" class="needs-validation nopadding">
    @csrf
    @include('content.query.queryWizardForms.query_form_section')
</form>