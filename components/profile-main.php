<?php
echo '
<div class="px-8 py-10">
  <div class="container mx-auto px-4">
    <div class="flex flex-col items-center">
      <div class="flex-shrink-0">
        <img class="w-32 h-32 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
      </div>
      <div class="flex-1 ml-4 py-4">
        <h2 class="text-2xl font-semibold">John Doe</h2>
        <div class="flex items-center text-gray-400 text-sm">
          <div class="flex-shrink-0">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"></path>
            </svg>
          </div>
            <div class="ml-1">
                <a href="#" class="text-gray-500">
                    <span class="font-semibold">@</span>
                    <span class="text-sm">john.doe</span>
                </a>
            </div>
        </div>
      </div>
<div class="flex-1 ml-4 py-4">
<button class="btn gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
  Button
</button>
<button class="btn gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
  Button
</button>
</div>
<div class="stats stats-vertical lg:stats-horizontal shadow items-center">
  <div class="stat">
    <div class="stat-title">Total Review</div>
    <div class="stat-value">31K</div>
    <div class="stat-desc">Jan 1st - Feb 1st</div>
  </div>
  <div class="stat">
    <div class="stat-title">Average Rating</div>
    <div class="stat-value">4.2⭐</div>
    <div class="stat-desc">↗︎ 400 (22%)</div>
  </div>
</div>
    </div>
  </div>
</div>
';
?>