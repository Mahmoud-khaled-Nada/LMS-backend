<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('sliders.index') }}" class="nav-link {{ Request::is('sliders*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Sliders</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('settings.index') }}" class="nav-link {{ Request::is('settings*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Settings</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('galleries.index') }}" class="nav-link {{ Request::is('galleries*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Galleries</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('contactuses.index') }}" class="nav-link {{ Request::is('contactuses*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Contactuses</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('pages.index') }}" class="nav-link {{ Request::is('pages*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Pages</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('facilites.index') }}" class="nav-link {{ Request::is('facilites*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Facilites</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('sideSeeings.index') }}" class="nav-link {{ Request::is('sideSeeings*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Side Seeings</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('newsletters.index') }}" class="nav-link {{ Request::is('newsletters*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Newsletters</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('excursions.index') }}" class="nav-link {{ Request::is('excursions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Excursions</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('activities.index') }}" class="nav-link {{ Request::is('activities*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Activities</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('ages.index') }}" class="nav-link {{ Request::is('ages*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Ages</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('capines.index') }}" class="nav-link {{ Request::is('capines*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Capines</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('cruises.index') }}" class="nav-link {{ Request::is('cruises*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Cruises</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('trips.index') }}" class="nav-link {{ Request::is('trips*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Trips</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('offers.index') }}" class="nav-link {{ Request::is('offers*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Offers</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('terms.index') }}" class="nav-link {{ Request::is('terms*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Terms</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('policies.index') }}" class="nav-link {{ Request::is('policies*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Policies</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('contacts.index') }}" class="nav-link {{ Request::is('contacts*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Contacts</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('blogs.index') }}" class="nav-link {{ Request::is('blogs*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Blogs</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('faciliteCategories.index') }}" class="nav-link {{ Request::is('faciliteCategories*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Facilite Categories</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('facilityTypes.index') }}" class="nav-link {{ Request::is('facilityTypes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Facility Types</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('services.index') }}" class="nav-link {{ Request::is('services*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Services</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('properties.index') }}" class="nav-link {{ Request::is('properties*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Properties</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('helpfulFacts.index') }}" class="nav-link {{ Request::is('helpfulFacts*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Helpful Facts</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('cancellationPolicies.index') }}" class="nav-link {{ Request::is('cancellationPolicies*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Cancellation  Policies</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('chooseuses.index') }}" class="nav-link {{ Request::is('chooseuses*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Chooseuses</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('dinings.index') }}" class="nav-link {{ Request::is('dinings*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dinings</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('accommodations.index') }}" class="nav-link {{ Request::is('accommodations*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Accommodations</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('tests.index') }}" class="nav-link {{ Request::is('tests*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Tests</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('categories.index') }}" class="nav-link {{ Request::is('categories*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Categories</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('lectures.index') }}" class="nav-link {{ Request::is('lectures*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Lectures</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('questions.index') }}" class="nav-link {{ Request::is('questions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Questions</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('lessons.index') }}" class="nav-link {{ Request::is('lessons*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Lessons</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('coupons.index') }}" class="nav-link {{ Request::is('coupons*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Coupons</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('packages.index') }}" class="nav-link {{ Request::is('packages*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Packages</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('intros.index') }}" class="nav-link {{ Request::is('intros*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Intros</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('books.index') }}" class="nav-link {{ Request::is('books*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Books</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('exams.index') }}" class="nav-link {{ Request::is('exams*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Exams</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('directClasses.index') }}" class="nav-link {{ Request::is('directClasses*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Direct Classes</p>
    </a>
</li>
