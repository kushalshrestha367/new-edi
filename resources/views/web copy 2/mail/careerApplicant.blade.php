<h2>New Career Application</h2>
<p>
    <strong>Name:</strong>
    {{ $data['name'] }}
</p>
<p>
    <strong>Email:</strong>
    {{ $data['email'] }}
</p>
<p>
    <strong>Phone:</strong>
    {{ $data['phone'] }}
</p>
<p>
    <strong>Cover Letter:</strong>
    <div>
        {!! $data['cover_letter'] !!}
    </div>
</p>
<a href="{{ asset('storage/' . $data['resume_path']->hashName()) }}">Download Your Resume</a>
<p>
    <strong>Career Position:</strong>
    {{ $careerData->title }}
</p>