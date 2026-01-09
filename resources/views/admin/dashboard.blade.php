<x-admin-layout>
    {{-- 1. Header & Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tổng quan hoạt động kinh doanh</p>
        </div>
        <a href="{{ route('admin.reports.export') }}"
            class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
            <i class="fa-solid fa-file-csv mr-2"></i> Xuất Báo Cáo
        </a>
    </div>

    {{-- 2. Thẻ Thống Kê Tổng Quan (4 Cards) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card 1: Doanh Thu --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Doanh Thu</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                        {{ number_format($totalRevenue, 0, ',', '.') }} đ</h3>
                </div>
                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600"><i
                        class="fa-solid fa-sack-dollar text-xl"></i></div>
            </div>
        </div>
        {{-- Card 2: Đơn Hàng --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Đơn Hàng</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($totalOrders) }}
                    </h3>
                </div>
                <div class="p-2 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg text-yellow-600"><i
                        class="fa-solid fa-cart-shopping text-xl"></i></div>
            </div>
        </div>
        {{-- Card 3: Khách Hàng --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Khách Hàng</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($totalUsers) }}
                    </h3>
                </div>
                <div class="p-2 bg-green-50 dark:bg-green-900/30 rounded-lg text-green-600"><i
                        class="fa-solid fa-users text-xl"></i></div>
            </div>
        </div>
        {{-- Card 4: Games --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Games</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($totalGames) }}
                    </h3>
                </div>
                <div class="p-2 bg-purple-50 dark:bg-purple-900/30 rounded-lg text-purple-600"><i
                        class="fa-solid fa-gamepad text-xl"></i></div>
            </div>
        </div>
    </div>

    {{-- 3. BIỂU ĐỒ DOANH THU (Line Chart) --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-8">
        {{-- Header của Chart --}}
        <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                <span id="chartTitle">Biểu đồ doanh thu Tuần này</span>
            </h3>

            {{-- Bộ nút chuyển đổi: Tuần / Tháng / Quý --}}
            <div class="flex bg-gray-100 dark:bg-gray-700 p-1 rounded-lg">
                <button onclick="updateChart('week')" id="btn-week"
                    class="px-4 py-1.5 text-sm font-medium rounded-md transition-all bg-white dark:bg-gray-600 text-indigo-600 dark:text-white shadow">
                    Tuần
                </button>
                <button onclick="updateChart('month')" id="btn-month"
                    class="px-4 py-1.5 text-sm font-medium rounded-md transition-all text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600 shadow-sm">
                    Tháng
                </button>
                <button onclick="updateChart('quarter')" id="btn-quarter"
                    class="px-4 py-1.5 text-sm font-medium rounded-md transition-all text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600 shadow-sm">
                    Quý
                </button>
            </div>
        </div>

        <div class="relative w-full h-80">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- 4. Bảng Giao Dịch --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
            <h3 class="font-bold text-lg text-gray-800 dark:text-white">Giao dịch mới nhất</h3>
            <a href="{{ route('admin.orders.index') }}"
                class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Xem tất cả &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold tracking-wider">
                        <th class="px-6 py-4">Mã Đơn</th>
                        <th class="px-6 py-4">Khách Hàng</th>
                        <th class="px-6 py-4 text-right">Tổng Tiền</th>
                        <th class="px-6 py-4 text-center">Trạng Thái</th>
                        <th class="px-6 py-4 text-right">Ngày Tạo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                            <td class="px-6 py-4 text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                #{{ $order->order_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-white">{{ $order->user->name ?? 'Guest' }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-gray-800 dark:text-white">
                                {{ number_format((float) (is_object($order->total_amount) ? $order->total_amount->__toString() : $order->total_amount), 0, ',', '.') }}
                                đ
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Chưa có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Script Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dataSets = {
            week: {
                labels: @json($chartWeek['labels']),
                data: @json($chartWeek['data']),
                title: 'Biểu đồ doanh thu tuần này'
            },
            month: {
                labels: @json($chartMonth['labels']),
                data: @json($chartMonth['data']),
                title: 'Biểu đồ doanh thu tháng này'
            },
            quarter: {
                labels: @json($chartQuarter['labels']),
                data: @json($chartQuarter['data']),
                title: 'Biểu đồ doanh thu quý này'
            }
        };

        let chartInstance = null;

        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;

            // Mặc định hiển thị Tuần này
            const initialData = dataSets.week;

            chartInstance = new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: initialData.labels,
                    datasets: [{
                        label: 'Doanh thu',
                        data: initialData.data,
                        backgroundColor: 'rgba(99, 102, 241, 0.15)',
                        borderColor: '#6366f1', // Indigo color
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#6366f1',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Đường cong mềm mại
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: {
                                display: false
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function (value) {
                                    if (value >= 1000000) return (value / 1000000) + 'tr';
                                    if (value >= 1000) return (value / 1000) + 'k';
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });

        function updateChart(type) {
            if (!chartInstance) return;

            const selectedData = dataSets[type];
            chartInstance.data.labels = selectedData.labels;
            chartInstance.data.datasets[0].data = selectedData.data;
            chartInstance.update();

            document.getElementById('chartTitle').innerText = selectedData.title;

            // Xử lý nút active
            document.querySelectorAll('button[id^="btn-"]').forEach(btn => {
                btn.className = "px-4 py-1.5 text-sm font-medium rounded-md transition-all text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600 shadow-sm";
            });
            const activeBtn = document.getElementById('btn-' + type);
            activeBtn.className = "px-4 py-1.5 text-sm font-medium rounded-md transition-all bg-white dark:bg-gray-600 text-indigo-600 dark:text-white shadow font-bold";
        }
    </script>
</x-admin-layout>