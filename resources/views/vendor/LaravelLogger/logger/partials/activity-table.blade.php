@php

$drilldownStatus = config('LaravelLogger.enableDrillDown');
$prependUrl = '/activity/log/';

if (isset($hoverable) && $hoverable === true) {
    $hoverable = true;
} else {
    $hoverable = false;
}

if (Request::is('activity/cleared')) {
    $prependUrl = '/activity/cleared/log/';
}

@endphp



<div class="table-responsive activity-table">
    <table class="table table-striped table-condensed table-sm @if(config('LaravelLogger.enableDrillDown') && $hoverable) table-hover @endif data-table">
        <thead>
            <tr>
                <th>
                    <i class="fa fa-database fa-fw" aria-hidden="true"></i>
                    <span class="hidden-sm hidden-xs">
                        {!! trans('LaravelLogger::laravel-logger.dashboard.labels.id') !!}
                    </span>
                </th>
                <th>
                    <i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>
                    {!! trans('LaravelLogger::laravel-logger.dashboard.labels.time') !!}
                </th>
                <th>
                    <i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i>
                    {!! trans('LaravelLogger::laravel-logger.dashboard.labels.description') !!}
                </th>
                <th>
                    <i class="fa fa-user-o fa-fw" aria-hidden="true"></i>
                    {!! trans('LaravelLogger::laravel-logger.dashboard.labels.user') !!}
                </th>
                <th>
                    <i class="fa fa-truck fa-fw" aria-hidden="true"></i>
                    <span class="hidden-sm hidden-xs">
                        {!! trans('LaravelLogger::laravel-logger.dashboard.labels.method') !!}
                    </span>
                </th>
                <th>
                    <i class="fa fa-truck fa-fw" aria-hidden="true"></i>
                    <span class="">
                        Veriler
                    </span>
                </th>
                <th>
                    <i class="fa fa-map-o fa-fw" aria-hidden="true"></i>
                    {!! trans('LaravelLogger::laravel-logger.dashboard.labels.route') !!}
                </th>
                <th>
                    <i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
                    {!! trans('LaravelLogger::laravel-logger.dashboard.labels.ipAddress') !!}
                </th>
                <th>
                    <i class="fa fa-laptop fa-fw" aria-hidden="true"></i>
                    {!! trans('LaravelLogger::laravel-logger.dashboard.labels.agent') !!}
                </th>
                @if(Request::is('activity/cleared'))
                    <th>
                        <i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>
                        {!! trans('LaravelLogger::laravel-logger.dashboard.labels.deleteDate') !!}
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>

            @foreach($activities as $activity)
                <tr @if($drilldownStatus && $hoverable) class="clickable-row" data-href="{{ url($prependUrl . $activity->id) }}" data-toggle="tooltip" title="{{trans('LaravelLogger::laravel-logger.tooltips.viewRecord')}}" @endif >
                    <td>
                        <small>
                            @if($hoverable)
                                {{ $activity->id }}
                            @else
                                <a href="{{ url($prependUrl . $activity->id) }}">
                                    {{ $activity->id }}
                                </a>
                            @endif
                        </small>
                    </td>
                    <td title="{{ $activity->created_at }}">
                        {{ $activity->timePassed }}
                    </td>
                    <td>
                        {{ $activity->description }}
                    </td>

                    <td>
                        @php
                            switch ($activity->userType) {
                                case trans('LaravelLogger::laravel-logger.userTypes.registered'):
                                    $userTypeClass = 'success';
                                    $userLabel = $activity->userDetails['name'];
                                    break;

                                case trans('LaravelLogger::laravel-logger.userTypes.crawler'):
                                    $userTypeClass = 'danger';
                                    $userLabel = $activity->userType;
                                    break;

                                case trans('LaravelLogger::laravel-logger.userTypes.guest'):
                                default:
                                    $userTypeClass = 'warning';
                                    $userLabel = $activity->userType;
                                    break;
                            }

                        @endphp
                        <span class="badge bg-{{$userTypeClass}}">
                            {{!empty($users[$activity->userId]->user_name) ? $users[$activity->userId]->user_name : $userLabel}}
                        </span>
                    </td>
                    <td style="color: black !important">
                        @php
                            switch (strtolower($activity->methodType)) {
                                case 'get':
                                    $methodClass = 'info';
                                    break;

                                case 'post':
                                    $methodClass = 'warning';
                                    break;

                                case 'put':
                                    $methodClass = 'warning';
                                    break;

                                case 'delete':
                                    $methodClass = 'danger';
                                    break;

                                default:
                                    $methodClass = 'info';
                                    break;
                            }
                        @endphp
                        <span class="badge bg-{{ $methodClass }}">
                            {{ $activity->methodType }}
                        </span>
                    </td>
                    <td>
                        <a style="color:white" class="{{(!empty($activity->details) && ($activity->details) != "[]")  ? "modalShow" : ""}} badge {{(!empty($activity->details) && ($activity->details) != "[]")  ? "bg-primary" : "bg-warning"}}">
                            {{(!empty($activity->details) && ($activity->details) != "[]") ? "Gör" : "---"}}
                        </a>
                        <span class='d-none'>
                            {{(!empty($activity->details) && ($activity->details) != "[]") ? $activity->details : null}}
                        </span>
                    </td>
                    <td>
                        @if($hoverable)
                            {{ showCleanRoutUrl($activity->route) }}
                        @else
                            <a href="{{ $activity->route }}">
                                {{$activity->route}}
                            </a>
                        @endif
                    </td>
                    <td>
                        {{ $activity->ipAddress }}
                    </td>
                    <td>
                        @php
                            $platform       = $activity->userAgentDetails['platform'];
                            $browser        = $activity->userAgentDetails['browser'];
                            $browserVersion = $activity->userAgentDetails['version'];

                            switch ($platform) {

                                case 'Windows':
                                    $platformIcon = 'fa-windows';
                                    break;

                                case 'iPad':
                                    $platformIcon = 'fa-';
                                    break;

                                case 'iPhone':
                                    $platformIcon = 'fa-';
                                    break;

                                case 'Macintosh':
                                    $platformIcon = 'fa-apple';
                                    break;

                                case 'Android':
                                    $platformIcon = 'fa-android';
                                    break;

                                case 'BlackBerry':
                                    $platformIcon = 'fa-';
                                    break;

                                case 'Unix':
                                case 'Linux':
                                    $platformIcon = 'fa-linux';
                                    break;

                                case 'CrOS':
                                    $platformIcon = 'fa-chrome';
                                    break;

                                default:
                                    $platformIcon = 'fa-';
                                    break;
                            }

                            switch ($browser) {

                                case 'Chrome':
                                    $browserIcon  = 'fa-chrome';
                                    break;

                                case 'Firefox':
                                    $browserIcon  = 'fa-';
                                    break;

                                case 'Opera':
                                    $browserIcon  = 'fa-opera';
                                    break;

                                case 'Safari':
                                    $browserIcon  = 'fa-safari';
                                    break;

                                case 'Internet Explorer':
                                    $browserIcon  = 'fa-edge';
                                    break;

                                default:
                                    $browserIcon  = 'fa-';
                                    break;
                            }
                        @endphp
                        <i class="fa {{ $browserIcon }} fa-fw" aria-hidden="true">
                            <span class="sr-only">
                                {{ $browser }}
                            </span>
                        </i>
                        <sup>
                            <small>
                                {{ $browserVersion }}
                            </small>
                        </sup>
                        <i class="fa {{ $platformIcon }} fa-fw" aria-hidden="true">
                            <span class="sr-only">
                                {{ $platform }}
                            </span>
                        </i>
                        <sup>
                            <small>
                                {{ $activity->langDetails }}
                            </small>
                        </sup>
                    </td>
                    @if(Request::is('activity/cleared'))
                        <td>
                            {{ $activity->deleted_at }}
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
            <p class="options d-none">
                Options:
                <label title="Generate node as collapsed">
                  <input type="checkbox" id="collapsed">Collapse nodes
                </label>
                <label title="Allow root element to be collasped">
                  <input type="checkbox" id="root-collapsable" checked>Root collapsable
                </label>
                <label title="Surround keys with quotes">
                  <input type="checkbox" id="with-quotes">Keys with quotes
                </label>
                <label title="Generate anchor tags for URL values">
                  <input type="checkbox" id="with-links" checked>
                  With Links
                </label>
              </p>
            <pre id="json-renderer"></pre>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <script src="{{asset('myAsset/jquery.json-viewer.js')}}"></script>
  <link href="{{asset('myAsset/jquery.json-viewer.css')}}" type="text/css" rel="stylesheet" />

<script>



$(function () {
/**
 * jQuery json-viewer
 * @author: Alexandre Bodelot <alexandre.bodelot@gmail.com>
 * @link: https://github.com/abodelot/jquery.json-viewer
 */
 (function ($) {
    /**
     * Check if arg is either an array with at least 1 element, or a dict with at least 1 key
     * @return boolean
     */
    function isCollapsable(arg) {
        return arg instanceof Object && Object.keys(arg).length > 0;
    }

    /**
     * Check if a string represents a valid url
     * @return boolean
     */
    function isUrl(string) {
        var urlRegexp =
            /^(https?:\/\/|ftps?:\/\/)?([a-z0-9%-]+\.){1,}([a-z0-9-]+)?(:(\d{1,5}))?(\/([a-z0-9\-._~:/?#[\]@!$&'()*+,;=%]+)?)?$/i;
        return urlRegexp.test(string);
    }

    /**
     * Transform a json object into html representation
     * @return string
     */
    function json2html(json, options) {
        var html = "";
        if (typeof json === "string") {
            // Escape tags and quotes
            json = json
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/'/g, "&apos;")
                .replace(/"/g, "&quot;");

            if (options.withLinks && isUrl(json)) {
                html +=
                    '<a href="' +
                    json +
                    '" class="json-string" target="_blank">' +
                    json +
                    "</a>";
            } else {
                // Escape double quotes in the rendered non-URL string.
                json = json.replace(/&quot;/g, "\\&quot;");
                html += '<span class="json-string">"' + json + '"</span>';
            }
        } else if (typeof json === "number") {
            html += '<span class="json-literal">' + json + "</span>";
        } else if (typeof json === "boolean") {
            html += '<span class="json-literal">' + json + "</span>";
        } else if (json === null) {
            html += '<span class="json-literal">null</span>';
        } else if (json instanceof Array) {
            if (json.length > 0) {
                html += '[<ol class="json-array">';
                for (var i = 0; i < json.length; ++i) {
                    html += "<li>";
                    // Add toggle button if item is collapsable
                    if (isCollapsable(json[i])) {
                        html += '<a href class="json-toggle"></a>';
                    }
                    html += json2html(json[i], options);
                    // Add comma if item is not last
                    if (i < json.length - 1) {
                        html += ",";
                    }
                    html += "</li>";
                }
                html += "</ol>]";
            } else {
                html += "[]";
            }
        } else if (typeof json === "object") {
            var keyCount = Object.keys(json).length;
            if (keyCount > 0) {
                html += '{<ul class="json-dict">';
                for (var key in json) {
                    if (Object.prototype.hasOwnProperty.call(json, key)) {
                        html += "<li>";
                        var keyRepr = options.withQuotes
                            ? '<span class="json-string">"' + key + '"</span>'
                            : key;
                        // Add toggle button if item is collapsable
                        if (isCollapsable(json[key])) {
                            html +=
                                '<a href class="json-toggle">' +
                                keyRepr +
                                "</a>";
                        } else {
                            html += keyRepr;
                        }
                        html += ": " + json2html(json[key], options);
                        // Add comma if item is not last
                        if (--keyCount > 0) {
                            html += ",";
                        }
                        html += "</li>";
                    }
                }
                html += "</ul>}";
            } else {
                html += "{}";
            }
        }
        return html;
    }

    /**
     * jQuery plugin method
     * @param json: a javascript object
     * @param options: an optional options hash
     */
    $.fn.jsonViewer = function (json, options) {
        // Merge user options with default options
        options = Object.assign(
            {},
            {
                collapsed: false,
                rootCollapsable: true,
                withQuotes: false,
                withLinks: true,
            },
            options
        );

        // jQuery chaining
        return this.each(function () {
            // Transform to HTML
            var html = json2html(json, options);
            if (options.rootCollapsable && isCollapsable(json)) {
                html = '<a href class="json-toggle"></a>' + html;
            }

            // Insert HTML in target DOM element
            $(this).html(html);
            $(this).addClass("json-document");

            // Bind click on toggle buttons
            $(this).off("click");
            $(this).on("click", "a.json-toggle", function () {
                var target = $(this)
                    .toggleClass("collapsed")
                    .siblings("ul.json-dict, ol.json-array");
                target.toggle();
                if (target.is(":visible")) {
                    target.siblings(".json-placeholder").remove();
                } else {
                    var count = target.children("li").length;
                    var placeholder = count + (count > 1 ? " items" : " item");
                    target.after(
                        '<a href class="json-placeholder">' +
                            placeholder +
                            "</a>"
                    );
                }
                return false;
            });

            // Simulate click on toggle button when placeholder is clicked
            $(this).on("click", "a.json-placeholder", function () {
                $(this).siblings("a.json-toggle").click();
                return false;
            });

            if (options.collapsed == true) {
                // Trigger click to collapse all nodes
                $(this).find("a.json-toggle").click();
            }
        });
    };
})(jQuery);

    $(".modalShow").on('click', function(){
            try {
                var input = eval('(' + $(this).siblings("span").html() + ')');
            } catch (error) {
                return alert("Cannot eval JSON: " + error);
            }
            var options = {
                collapsed: $('#collapsed').is(':checked'),
                rootCollapsable: $('#root-collapsable').is(':checked'),
                withQuotes: $('#with-quotes').is(':checked'),
                withLinks: $('#with-links').is(':checked')
            };
            $('#json-renderer').jsonViewer(input, options);

            $("#logModal").modal("show");

    });


});




    </script>
@if(config('LaravelLogger.  '))
    <div class="text-center">
        <div class="d-flex justify-content-center">
            {!! $activities->render() !!}
        </div>
        <p>
            {!! trans('LaravelLogger::laravel-logger.pagination.countText', ['firstItem' => $activities->firstItem(), 'lastItem' => $activities->lastItem(), 'total' => $activities->total(), 'perPage' => $activities->perPage()]) !!}
        </p>
    </div>
@endif
