# php-ds-array-benchmark

A php8.2 benchmark comparison between native **Array**, **SplFixedArray** and **Vector** from php-ds (data-structures extensions).

# Usage

	./vendor/bin/phpbench run tests/Benchmark --report=aggregate --retry-threshold=5
	
# Result

### Without json_encode

| benchmark  | subject            | set | revs | its | mem_peak | mode        | rstdev |
|------------|--------------------|-----|------|-----|----------|-------------|--------|
| ArrayBench | benchArray         |     | 10   | 3   | 1.126gb  | 492.811ms   | ±1.31% |
| ArrayBench | benchSplFixedArray |     | 10   | 3   | 1.087gb  | 537.613ms   | ±2.15% |
| ArrayBench | benchDsVector      |     | 10   | 3   | 1.084gb  | 1,021.727ms | ±0.19% |

### With json_encode

| benchmark  | subject            | set | revs | its | mem_peak | mode        | rstdev |
|------------|--------------------|-----|------|-----|----------|-------------|--------|
| ArrayBench | benchArray         |     | 10   | 3   | 1.405gb  | 1,565.699ms | ±1.01% |
| ArrayBench | benchSplFixedArray |     | 10   | 3   | 1.600gb  | 2,087.920ms | ±0.71% |
| ArrayBench | benchDsVector      |     | 10   | 3   | 1.388gb  | 2,137.282ms | ±0.61% |

# Conclusion

- **Native array is the best data structure for lists, and outperforms the other methods in both time complexity and overall resource usage.**
- SplFixedArray is simply garbage for php8. It has no value over array in any way.
- DataStructures extension was once a great improvement for php7, but so much anymore, at least for simple lists. Certain things can be still much more efficient with [php-ds](https://medium.com/@rtheunissen/efficient-data-structures-for-php-7-9dda7af674cd).