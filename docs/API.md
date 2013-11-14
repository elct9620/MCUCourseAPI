銘傳大學 課程資訊 API
===

這份文件是銘傳大學第三方的課程 API 文件，在目前的版本中，可以獲取當學期（或者選課期間下一學期）的課程資訊。

文件中，會詳細敘述關於 API 的使用以及參數資訊。

更新記錄
---

### 2013-11-14
> 本次更新為加入規範文件，大部份的 API 可能尚未完善。

規格
---

以下所有的傳輸都以 `GET` 方式存取，並且皆為 `Read-only` 資料，系統會定期透過[課程分析系統](https://github.com/elct9620/MCUCourseCLI)更新課程資訊。

所有傳回資訊皆以 `JSON` 格式呈現，並且可以透過加入 `callback` 參數改以 `JSONP` 的方式回傳。

資源
---

第一項為範例，將會說明文件的閱讀方式。

### `/resource/(:code)` 範例資源

此項資源傳回資訊的簡介。

> 使用 () 包覆者為 RESTFUL 格式的查訊，本範例表示應傳入一個 code 資料。

### 參數

參數中，第一個數值為參數名稱，括號中的 Tag 則為類型，最後是此項參數的說明。

* `name` (`filter`) 過濾項目，通常指以 `LIKE '%DATA%'` 方式查詢的資料，大多時候會將項目篩選。
* `page` (`number`) 數值項目，通常用於只定頁碼。
* `with` (`array`) 陣列項目，通常是以「course,departement」的方式呈現，通常指使用 `JOIN` 方式查詢的資料。
* [#TODO] `param` (`filter`) 前方有 [#TODO] 的 Prefix 表示這項功能仍在開發中。

### 範例

傳回資料可能呈現的情況，有時會以 ... 代表仍有多筆項目。

``` json
[
	{
		id: "1",
		code: "00",
		name: "通識教育中心",
		created_at: "2013-10-31 09:19:43",
		updated_at: "2013-10-31 09:19:43"
	},
	...
]
```

### 程式

用來呈現實際使用方式的範例程式，大多數時候皆以 JavaScript 為範例。

``` js
/**
 * API Request Demo
 *
 * @require jQuery 說明相依的 JavaScript 套件
 */
 
 $.get('http://mcu-course-api.herokuapp.com/', function(data){
   console.log('API Version' + data.api.version);
 });

```

---

### `/` 首頁

顯示目前資料的最後更新時間以及 API 介面的版本。

#### 參數

無

#### 範例

``` json
{
 api: {
 	version: '0.1',
 	last_update: '2013-10-31'
 }
}

```

### `/status` [#TODO] 資料更新狀態

傳回資料庫各項資料庫的更新狀態

#### 參數

無

#### 範例

無

### `/departments` 學系列表

傳回學校課程系統上所公佈之學系列表。

#### 參數

* `name` (`filter`) 學系名稱，可以篩選學系中包含此文字的項目。
* `page` (`number`) 頁碼。

#### 範例

``` json
[
	items[{
		id: "1",
		code: "00",
		name: "通識教育中心",
		created_at: "2013-10-31 09:19:43",
		updated_at: "2013-10-31 09:19:43"
	},
	...],
	next: 2,
	first: 1,
	before: 1,
	current: 1,
	last: 3,
	total_pages: 3,
	total_items: 53
]
```

### `/department/(:code)` 學系資訊

傳回某一學系的基本資訊。

`code` 應為學系代碼，如： 00 通是教育中心

#### 參數

* [#TODO] `with` (`array`) 合併查詢，可用的項目如下
	* `course` 相關課程資訊

#### 範例

``` json

{
	id: "1",
	code: "00",
	name: "通識教育中心",
	created_at: "2013-10-31 09:19:43",
	updated_at: "2013-10-31 09:19:43"
}

```

### `/courses` 課程列表

傳回學校系統上可辨識的課程資訊。
> 因為並非直接存取學校資料庫，可能會有部分資料存取不正常，如果有發現請進快回報。

#### 參數

* `name` (`filter`) 課程名稱
* `course_code` (`filter`) 課程代碼
* `class_code` (`filter`) 班級代碼
* `page` (`number`) 頁碼
* [#TODO] `with` (`array`) 合併查詢
	* `teacher` 教師資訊
	* `course_time` 上課時間
* [#TODO] `department` (`filter`) 學系代碼

#### 範例

``` json
{
	items:[{
		id: "1",
		system: "1",
		course_code: "02018",
		course_name: "攝影藝術欣賞",
		class_code: "00101",
		max_people: "108",
		selected_people: "79",
		year: "0",
		select_type: "1",
		credit: "2",
		class_type: null,
		semester: "1",
		created_at: "2013-10-31 09:20:03",
		updated_at: "2013-10-31 09:20:03"
	},
	...],
	next: 2,
	first: 1,
	before: 1,
	current: 1,
	last: 82,
	total_pages: 82,
	total_items: 2032
}
```

### `/course/(:id)` 課程資訊

傳回某項課程的資訊

`id` 應為課程編號 [#TODO: 應修正為其他更具代表性的項目]

#### 參數

* [#TODO] `with` (`array`) 合併查詢
	* `teacher` 教師資訊
	* `course_time` 上課時間 

#### 範例

``` json
{
	id: "1",
	system: "1",
	course_code: "02018",
	course_name: "攝影藝術欣賞",
	class_code: "00101",
	max_people: "108",
	selected_people: "79",
	year: "0",
	select_type: "1",
	credit: "2",
	class_type: null,
	semester: "1",
	created_at: "2013-10-31 09:20:03",
	updated_at: "2013-10-31 09:20:03"
}
```

### `/teachers` [#TODO] 教師列表

傳回學校已知的教師列表（會因課程而重複出現）。

#### 參數

* `name` (`filter`) 教師名稱
* `class_room` (`filter`) 上課教室
* `course_day` (`number`) 上課時間（星期）
* `with` (`array`) 合併查詢
	* `course` 課程資訊
	* `course_time` 上課時間（節） 

#### 範例

無

### `/teachers/(:name)` [#TODO] 教師資訊

傳回某一教師資訊。

`name` 需為教師名稱（如有同名教師或者重複，則改為傳回陣列）

#### 參數

* `class_room` (`filter`) 上課教室
* `course_day` (`number`) 上課時間（星期）
* `with` (`array`) 合併查詢
	* `course` 課程資訊
	* `course_time` 上課時間（節） 

#### 範例

無