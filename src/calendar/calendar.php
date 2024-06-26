<?php
require('../assets/php/dbconnect.php');
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: /auth/sign_in.php");
  // 外部から来たらログインページに遷移
  exit();
}
$calendars = "SELECT calendars.*, plans.name as event_theme, user_details.name as name FROM calendar_plan join calendars on calendar_plan.calendar_id = calendars.id join plans on calendar_plan.plan_id = plans.id join user_details on calendars.userdetail_id = user_details.user_id ";
$stmt = $dbh->query($calendars);
$calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);
// echo '<pre>';
// print_r($calendars);
// echo '</pre>';
$calendars_json = json_encode($calendars);
// 該当posseを検索し、そのuser全てを取得する
$sql_posse = "SELECT posse from user_details where user_id = :user_id";
$stmt = $dbh->prepare($sql_posse);
$stmt->execute([
  ':user_id' => $_SESSION['id']
]);
$posse = $stmt->fetch(PDO::FETCH_ASSOC);
$sql = "SELECT name, discord_user_id, grade, image FROM `user_details` WHERE `posse` = :posse";
$stmt = $dbh->prepare($sql);
$stmt->execute([
  ':posse' => $posse['posse']
]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// echo '<pre>';
// print_r($users);
// echo '</pre>';

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="../assets/style/reset.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style/index.css">
  <link href="../dist/output.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="dns-prefetch" href="//unpkg.com" />
  <link rel="stylesheet" href="../assets/style/header.css">
  <link rel="dns-prefetch" href="//cdn.jsdelivr.net" />
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
  <script type="text/javascript" src="../node_modules/tw-elements/dist/js/tw-elements.umd.min.js" defer></script>
  <?php echo "<script>
  var calendarsData = $calendars_json;
</script>";
  ?>

</head>

<body class="min-h-screen flex flex-col  md:min-h-0 md:mb-12">
  <?php require("../components/header.php")?>

  <div>



    <style>
      [x-cloak] {
        display: none;
      }
    </style>

    <div class="antialiased sans-serif bg-gray-100 h-screen md:mb-48 md:min-h-0">
      <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
        <div class=" mx-auto py-4 md:py-8 w-full mb-3">

          <div class="font-bold text-gray-800 text-xl flex justify-center font-cursive mb-4 md:text-2xl lg:text-3xl xl:text-4xl md:mt-4 md:mb-12">
            When you coming?
          </div>


          <div class="bg-white rounded-lg shadow overflow-hidden">

            <div class="flex items-center justify-between py-2 relative px-1 gap-1">
              <div class="mr-1">
                <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
              </div>
              <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2  ">
                <span class="border-blue-100 bg-blue-100 text-blue-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded ">業務</span>
                <span class="border-red-200 bg-red-100 text-red-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded ">縦・横モク</span>
                <span class="border-yellow-200 bg-yellow-200 text-yellow-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">MU</span>
                <span class="border-green-100 bg-green-100 text-green-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">カリキュラム</span>
                <span class="border-gray-100 bg-gray-100 text-gray-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded ">その他</span>
              </div>
              <div class="border rounded-lg px-1" style="padding-top: 2px;">
                <button type="button" class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center" :class="{'cursor-not-allowed opacity-25': month == 0 }" :disabled="month == 0 ? true : false" @click="month--; getNoOfDays()">
                  <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                  </svg>
                </button>
                <div class="border-r inline-flex h-6"></div>
                <button type="button" class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1" :class="{'cursor-not-allowed opacity-25': month == 11 }" :disabled="month == 11 ? true : false" @click="month++; getNoOfDays()">
                  <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </button>
              </div>
            </div>

            <div class="-mx-1 -mb-1">
              <div class="flex flex-wrap" style="margin-bottom: -40px;">
                <template x-for="(day, index) in DAYS" :key="index">
                  <div style="width: 14.26%" class="px-2 py-2">
                    <div x-text="day" class="text-gray-600 text-sm uppercase tracking-wide font-bold text-center"></div>
                  </div>
                </template>
              </div>

              <div class="flex flex-wrap border-t border-l">
                <template x-for="blankday in blankdays">
                  <div style="width: 14.28%; height: 120px" class="text-center border-r border-b px-4 pt-2"></div>
                </template>
                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                  <div style="width: 14.28%; height: 120px" class=" pt-2 border-r border-b relative">
                    <div @click="showEventModal(date)" x-text="date" class="inline-flex w-6 h-6 items-center justify-center cursor-pointer text-center leading-none rounded-full transition ease-in-out duration-100" :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"></div>
                    <div style="height: 80px;" class="overflow-y-auto mt-1">
                      <div class="absolute top-0 right-0 mt-2 mr-2 inline-flex items-center justify-center rounded-full text-sm w-6 h-6 bg-gray-700 text-white leading-none" x-show="events.filter(e => e.event_date === new Date(year, month, date).toDateString()).length" x-text="events.filter(e => e.event_date === new Date(year, month, date).toDateString()).length"></div>

                      <template x-for="event in events.filter(e => new Date(e.event_date).toDateString() ===  new Date(year, month, date).toDateString() )">
                        <div class="py-1 rounded-lg mt-1 overflow-hidden border" :class="{
												'border-blue-200 text-blue-800 bg-blue-100': event.event_color === '業務',
												'border-red-200 text-red-800 bg-red-100': event.event_color === '縦・横モク',
												'border-gray-200 text-gray-800 bg-gray-100': event.event_color === 'その他',
                        'border-yellow-200 text-yellow-800 bg-yellow-100': event.event_color === 'MU',
												'border-green-200 text-green-800 bg-green-100': event.event_color === 'カリキュラム',
											}">
                          <p x-text="event.event_theme" class="text-sm truncate leading-tight"></p>
                        </div>
                      </template>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div style=" background-color: rgba(0, 0, 0, 0.8)" class="fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full" x-show.transition.opacity="openEventModal">
          <div class=" max-w-xl mx-auto relative  left-0 right-0 overflow-hidden mt-24">
            <div class="shadow absolute right-0 top-0 w-10 h-10 rounded-full bg-white text-gray-500 hover:text-gray-800 inline-flex items-center justify-center cursor-pointer" x-on:click="openEventModal = !openEventModal">
              <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
              </svg>
            </div>

            <form class="shadow w-full rounded-lg bg-white overflow-hidden block p-8" method="post" action="../assets/php/calendar/calendar.php">

              <h2 class=" text-2xl mb-6 border-b pb-2 font-medium text-gray-900">予定登録</h2>

              <div class="mb-4">
                <label class="block mb-1 tracking-wide text-sm font-medium text-gray-900">日時</label>
                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" x-model="event_date" readonly name="event_date">
              </div>

              <div class="flex gap-1 align-middle">
                <div class="mt-2 p-4 w-32 bg-white rounded-lg shadow-xl">
                  <div class="flex">
                    <select name="start_hours" class="bg-transparent text-xl appearance-none outline-none">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">10</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                      <option value="16">16</option>
                      <option value="17">17</option>
                      <option value="18">18</option>
                      <option value="19">19</option>
                      <option value="20">20</option>
                      <option value="21">21</option>
                      <option value="22">22</option>
                      <option value="23">23</option>
                    </select>
                    <span class="text-xl mr-3">:</span>
                    <select name="start_minutes" class="bg-transparent text-xl appearance-none outline-none mr-4">
                      <option value="0">00</option>
                      <option value="30">30</option>
                    </select>
                  </div>
                </div>
                <div class="mt-5">~</div>
                <div class="mt-2 p-4 w-32 bg-white rounded-lg shadow-xl">
                  <div class="flex">
                    <select name="end_hours" class="bg-transparent text-xl appearance-none outline-none">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">10</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                      <option value="16">16</option>
                      <option value="17">17</option>
                      <option value="18">18</option>
                      <option value="19">19</option>
                      <option value="20">20</option>
                      <option value="21">21</option>
                      <option value="22">22</option>
                      <option value="23">23</option>
                    </select>
                    <span class="text-xl mr-3">:</span>
                    <select name="end_minutes" class="bg-transparent text-xl appearance-none outline-none mr-4">
                      <option value="0">00</option>
                      <option value="30">30</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="inline-block w-64 mb-4">
                <label class=" block mb-1  tracking-wide　text-sm font-medium text-gray-900">何するの？</label>
                <div class="relative">
                  <select @change="event_theme = $event.target.value;" x-model="event_theme" class="block appearance-none w-full bg-gray-200 border-2 border-gray-200 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-gray-700" name="plan">
                    <template x-for="(theme, index) in themes">
                      <option :value="theme.value" x-text="theme.label"></option>
                    </template>

                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                  </div>
                </div>
              </div>

              <div class="inline-block w-64 mb-4">
                <div class="relative">
                  <label for="countries_multiple" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">リクエスト</label>
                  <select multiple id="countries_multiple" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="name[]">
                    <?php foreach ($users as $user) : ?>
                      <option value="<?php echo $user['name']; ?>"><?php echo $user['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                  </div>
                </div>
              </div>

              <div class="mt-8 text-right">
                <button type="button" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm mr-2" @click="openEventModal = !openEventModal">
                  キャンセル
                </button>
                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm" @click="addEvent()">
                  登録
                </button>
              </div>
            </form>
          </div>
        </div>
        <!-- /Modal -->
      </div>
      <script>
        const MONTH_NAMES = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        function app() {
          return {
            month: '',
            year: '',
            no_of_days: [],
            blankdays: [],
            days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

            events: [],
            event_date: '',
            event_start_time: '',
            event_end_time: '',
            event_theme: 'blue',

            themes: [{
                value: "1",
                label: "業務"
              },
              {
                value: "2",
                label: "縦・横モク"
              },
              {
                value: "3",
                label: "カリキュラム"
              },
              {
                value: "4",
                label: "MU"
              },
              {
                value: "5",
                label: "その他"
              },
            ],

            openEventModal: false,

            initEvents() {
              calendarsData.forEach(calendar => {
                this.events.push({
                  event_date: new Date(calendar.date + ' ' + calendar.start_time),
                  event_start_time: calendar.start_time,
                  event_end_time: calendar.end_time,
                  event_color: calendar.event_theme,
                  event_theme: calendar.name
                });
              });
            },
            initDate() {
              let today = new Date();
              this.month = today.getMonth();
              this.year = today.getFullYear();
              this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
              this.initEvents();
            },

            isToday(date) {
              const today = new Date();
              const d = new Date(this.year, this.month, date);

              return today.toDateString() === d.toDateString() ? true : false;
            },

            showEventModal(date) {
              // open the modal
              this.openEventModal = true;
              this.event_date = new Date(this.year, this.month, date).toDateString();
            },

            addEvent() {
              if (this.event_title == '') {
                return
              }

              this.events.push({
                event_date: this.event_date,
                event_start_time: this.event_start_time,
                event_end_time: this.event_end_time,
                event_theme: this.event_theme
              });

              console.log(this.events);

              // clear the form data
              this.event_date = '';
              this.event_start_time = '';
              this.event_end_time = '';
              this.event_theme = 'blue';

              //close the modal
              this.openEventModal = false;
            },

            getNoOfDays() {
              let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

              // find where to start calendar day of week
              let dayOfWeek = new Date(this.year, this.month).getDay();
              let blankdaysArray = [];
              for (var i = 1; i <= dayOfWeek; i++) {
                blankdaysArray.push(i);
              }

              let daysArray = [];
              for (var i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
              }

              this.blankdays = blankdaysArray;
              this.no_of_days = daysArray;
            }
          }
        }
      </script>
    </div>
    <?php require("../components/footer.php") ?>

</body>

</html>