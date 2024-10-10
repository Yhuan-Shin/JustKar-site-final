<div wire:poll.3000ms>
        <h3>Unauthorized Access Notifications</h3>
        
        <ul>
            <table class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($notifications as $notification)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $notification->data['ip_address'] }}</td>
                            <td>{{ $notification->created_at->timezone('Asia/Manila')->format('m/d/Y, h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $notifications->links() }}

           
        </ul>
    
</div>
