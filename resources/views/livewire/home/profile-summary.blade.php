<section class="min-w-[20rem]"><!-- Profile Section -->
    <img src="{{ asset('storage/placeholder-avatars/funEmoji-1702910749853.jpg') }}" alt="Avatar"
        class="w-full mb-8 border rounded-xl">
    <div class="mb-4">
        <h2 class="text-xl font-bold capitalize">{{ auth()->user()->name }}</h2>
        <p class="text-xl text-gray-600 capitalize">{{ 'Pengurus Besar Khidmat Sokongan' }}</p>
    </div>
    <a href="" class="w-full btn btn-neutral">Kemaskini Profil</a>
    <div class="divider"></div>
    <div class="w-full bg-white border stats stats-vertical">

        <div class="stat">
            <div class="stat-title">Log Kerja</div>
            <div class="stat-value">31K</div>
            <div class="stat-desc">Disember 2023</div>
        </div>

        <div class="stat">
            <div class="stat-title">New Users</div>
            <div class="stat-value">4,200</div>
            <div class="stat-desc">↗︎ 400 (22%)</div>
        </div>

        <div class="stat">
            <div class="stat-title">New Registers</div>
            <div class="stat-value">1,200</div>
            <div class="stat-desc">↘︎ 90 (14%)</div>
        </div>

    </div>
</section><!-- Profile Section -->
